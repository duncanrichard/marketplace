<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::latest()->whereNull('deleted_at')->get();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        return view('visits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kunjungan' => 'required|string|max:255',
            'lokasi_kunjungan' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'no_pic' => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('visit', 'public');
        }

        $validated['created_by'] = Auth::user()->name;

        Visit::create($validated);

        return redirect()->route('visits.index')->with('success', 'Kunjungan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->deleted_by = Auth::user()->name;
        $visit->save();
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Kunjungan berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kunjungan' => 'required|string|max:255',
            'lokasi_kunjungan' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'no_pic' => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $visit = Visit::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($visit->file_path) {
                Storage::disk('public')->delete($visit->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('visit', 'public');
        }

        $validated['updated_by'] = Auth::user()->name;

        $visit->update($validated);

        return redirect()->route('visits.index')->with('success', 'Kunjungan berhasil diperbarui.');
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

            if (empty($row['nama_kunjungan']) || empty($row['lokasi_kunjungan'])) {
                continue;
            }

            Visit::create([
                'nama_kunjungan'     => $row['nama_kunjungan'],
                'lokasi_kunjungan'   => $row['lokasi_kunjungan'],
                'pic'                => $row['pic'] ?? '-',
                'no_pic'             => $row['no_pic'] ?? '-',
                'tanggal_kunjungan'  => Carbon::parse($row['tanggal_kunjungan']),
                'created_by'         => Auth::user()->name,
            ]);
        }

        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil diimport.');
    }
}