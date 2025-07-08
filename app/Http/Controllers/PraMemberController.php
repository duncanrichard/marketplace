<?php

namespace App\Http\Controllers;

use App\Models\PengajuanEvent;
use Illuminate\Http\Request;
use App\Models\PraMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Imports\PraMemberImport;
use Maatwebsite\Excel\Facades\Excel;



class PraMemberController extends Controller
{
    public function show($id)
    {
        $event = PengajuanEvent::with(['kebutuhan', 'brand'])->findOrFail($id);

        if ($event->status !== 'Confirmed') {
            abort(403, 'Event belum dikonfirmasi.');
        }

        $isExpired = now()->toDateString() > $event->tanggal;

        if ($isExpired) {
            return view('pra-member.expired', compact('event'));
        }

        return view('pra-member.show', compact('event'));
    }


    public function store(Request $request, $id)
    {
        $event = PengajuanEvent::findOrFail($id);

        if ($event->status !== 'Confirmed') {
            abort(403, 'Event belum dikonfirmasi.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ Cek apakah sudah pernah daftar dengan nomor telepon dan event yang sama
        $existing = PraMember::where('pengajuan_event_id', $event->id)
            ->where('telepon', $request->telepon)
            ->first();

        if ($existing) {
            return redirect()->route('pra-member.show', $event->id)
                ->with('duplicate', true)
                ->with('nama', $existing->nama);
        }

        PraMember::create([
            'pengajuan_event_id' => $event->id,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pra-member.show', $event->id)->with('success', 'Pendaftaran berhasil!');
    }
    public function importForm()
    {
        $praMembers = PraMember::whereNull('pengajuan_event_id')->latest()->get();

        return view('pra-member.import', compact('praMembers'));
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new PraMemberImport, $request->file('file'));

            return back()->with('success', 'Import berhasil dilakukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}