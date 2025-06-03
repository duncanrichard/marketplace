<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPasien;
use App\Models\Reservasi;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        $grouped = Reservasi::with('pasien')
            ->whereHas('pasien')
            ->orderBy('tanggal_reservasi', 'desc')
            ->get()
            ->groupBy('pasien_id');

        return view('reservasi.index', compact('grouped'));
    }

    public function create(Request $request)
    {
        $pasien = DataPasien::findOrFail($request->pasien_id);
        return view('reservasi.create', compact('pasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:data_pasiens,id',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi' => 'required',
            'status_reservasi' => 'required|in:Pending,Dikonfirmasi,Batal,Booked,Reschedule'
        ]);

        Reservasi::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_reservasi' => $request->jam_reservasi,
            'status_reservasi' => $request->status_reservasi,
            'catatan' => $request->catatan ?? null,
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil disimpan.');
    }

    public function detail($pasien_id)
    {
        $pasien = DataPasien::findOrFail($pasien_id);
        $reservasis = Reservasi::where('pasien_id', $pasien_id)
            ->orderBy('id', 'desc')
            ->get();

        return view('reservasi.detail', compact('pasien', 'reservasis'));
    }

    public function konfirmasiKedatangan(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->jam_kedatangan = $request->jam_kedatangan ?? Carbon::now()->format('H:i:s');
        $reservasi->status_reservasi = 'Dikonfirmasi';
        $reservasi->save();

        return back()->with('success', 'Kedatangan pasien berhasil dikonfirmasi.');
    }

    public function reschedule(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required|exists:reservasis,id',
            'aksi' => 'required|in:reschedule,batal',
            'tanggal_reschedule' => 'required_if:aksi,reschedule|date|nullable',
            'jam_reschedule' => 'required_if:aksi,reschedule|nullable',
        ]);

        $reservasi = Reservasi::findOrFail($request->id_reservasi);

        if ($request->aksi === 'reschedule') {
            $reservasi->status_reservasi = 'Batal';
            $reservasi->catatan = 'Jadwal lama dibatalkan karena reschedule ke tanggal ' . $request->tanggal_reschedule . ' jam ' . $request->jam_reschedule;
            $reservasi->save();

            Reservasi::create([
                'pasien_id' => $reservasi->pasien_id,
                'tanggal_reservasi' => $request->tanggal_reschedule,
                'jam_reservasi' => $request->jam_reschedule,
                'status_reservasi' => 'Reschedule',
                'catatan' => 'Reservasi hasil reschedule.',
            ]);
        } else {
            $reservasi->status_reservasi = 'Batal';
            $reservasi->catatan = 'Reservasi dibatalkan oleh admin.';
            $reservasi->save();
        }

        return redirect()->back()->with('success', 'Konfirmasi berhasil diproses.');
    }
}
