<?php

namespace App\Http\Controllers;

use App\Models\StrategicPartnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StrategicPartnershipController extends Controller
{
    public function index()
    {
        $items = StrategicPartnership::latest()->get();
        return view('strategic-partnerships.index', compact('items'));
    }

    public function create()
    {
        return view('strategic-partnerships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kerjasama' => 'required|unique:strategic_partnerships,kode_kerjasama',
            'nama_kerjasama' => 'required|string|max:255',
            'tanggal_kerjasama' => 'required|date',
            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:' . $request->input('tanggal_kerjasama'),
            ],
            'nama_marketing' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'telepon_pic' => 'required|string|max:20',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);


        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('partnerships', 'public');
        }

        $item = StrategicPartnership::create($validated);

        activity()
            ->performedOn($item)
            ->causedBy(Auth::user())
            ->withProperties(['created_by' => Auth::user()->name])
            ->log('Menambahkan Strategic Partnership');

        return redirect()->route('strategic-partnerships.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $item = StrategicPartnership::findOrFail($id);
        $item->delete();

        activity()
            ->performedOn($item)
            ->causedBy(Auth::user())
            ->withProperties(['deleted_by' => Auth::user()->name])
            ->log('Menghapus Strategic Partnership');

        return back()->with('success', 'Data berhasil dihapus.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        $data = Excel::toArray([], $request->file('file'))[0];
        $header = array_map('strtolower', $data[0]);
        unset($data[0]);

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            if (empty($row['kode_kerjasama']) || empty($row['nama_kerjasama']) || empty($row['tanggal_kerjasama'])) {
                continue;
            }

            StrategicPartnership::create([
                'kode_kerjasama' => $row['kode_kerjasama'],
                'nama_kerjasama' => $row['nama_kerjasama'],
                'tanggal_kerjasama' => $row['tanggal_kerjasama'],
                'tanggal_selesai' => $row['tanggal_selesai'] ?? $row['tanggal_kerjasama'],
                'nama_marketing' => $row['nama_marketing'] ?? '-',
                'nama_pic' => $row['nama_pic'] ?? '-',
                'telepon_pic' => $row['telepon_pic'] ?? '-',
            ]);
        }

        return back()->with('success', 'Data kerjasama berhasil diimport.');
    }
}