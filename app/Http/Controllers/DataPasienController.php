<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class DataPasienController extends Controller
{
    public function index()
    {
        // Ambil semua pasien dengan reservasi yang statusnya 'Booked'
       $pasien = DataPasien::with('reservasis')->get();


        return view('data-pasien.index', compact('pasien'));
    }

    public function create()
    {
        $last = DataPasien::orderBy('id', 'desc')->first();
        $urutan = $last ? intval(substr($last->no_cm, 2)) + 1 : 1;
        $no_cm = 'CM' . str_pad($urutan, 6, '0', STR_PAD_LEFT);

        return view('data-pasien.create', compact('no_cm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
           'no_ktp' => [
                'required',
                \Illuminate\Validation\Rule::unique('data_pasiens')->whereNull('deleted_at'),
            ],

            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required',
            'tanggal_pendaftaran' => 'required|date',
            'alamat' => 'required',
            'agama' => 'nullable|string',
            'email' => 'nullable|email',
            'status_pernikahan' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'catatan_pasien' => 'nullable|string',
            'telat' => 'nullable|string',
            'tidak_dilayani' => 'nullable|string',
            
            'provinsi' => 'nullable|string',
            'kota' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'hubungan' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
            'alamat_wali' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();

        // Generate nomor CM
        $last = DataPasien::orderBy('id', 'desc')->first();
        $urutan = $last ? intval(substr($last->no_cm, 2)) + 1 : 1;
        $data['no_cm'] = 'CM' . str_pad($urutan, 6, '0', STR_PAD_LEFT);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('image/pasien'), $namaFoto);
            $data['foto'] = 'image/pasien/' . $namaFoto;
        }

        DataPasien::create($data);

        return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil disimpan.');
    }

    public function edit($id)
    {
        $pasien = DataPasien::findOrFail($id);
        return view('data-pasien.edit', compact('pasien'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'no_ktp' => [
            'required',
            \Illuminate\Validation\Rule::unique('data_pasiens')->ignore($id)->whereNull('deleted_at'),
        ],

        'jenis_kelamin' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'no_hp' => 'required',
        'tanggal_pendaftaran' => 'required|date',
        'alamat' => 'required',
        'agama' => 'nullable|string',
        'email' => 'nullable|email',
        'status_pernikahan' => 'nullable|string',
        'golongan_darah' => 'nullable|string',
        'pendidikan' => 'nullable|string',
        'pekerjaan' => 'nullable|string',
        'keterangan' => 'nullable|string',
        'catatan_pasien' => 'nullable|string',
        'telat' => 'nullable|string',
        'tidak_dilayani' => 'nullable|string',
        'provinsi' => 'nullable|string',
        'kota' => 'nullable|string',
        'kecamatan' => 'nullable|string',
        'kelurahan' => 'nullable|string',
        'nama_wali' => 'nullable|string',
        'hubungan' => 'nullable|string',
        'no_hp_wali' => 'nullable|string',
        'alamat_wali' => 'nullable|string',
        'catatan_pasien' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $pasien = DataPasien::findOrFail($id);
    $data = $request->except('foto');

    $data['catatan_pasien'] = $request->catatan_pasien;

    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $namaFoto = time() . '_' . $foto->getClientOriginalName();
        $foto->move(public_path('image/pasien'), $namaFoto);
        $data['foto'] = 'image/pasien/' . $namaFoto;
    } else {
        $data['foto'] = $pasien->foto;
    }

    $pasien->update($data);

    return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
}

    public function show($id)
    {
        $pasien = DataPasien::findOrFail($id);
        return view('data-pasien.show', compact('pasien'));
    }

    public function destroy($id)
{
    $pasien = DataPasien::findOrFail($id);
    $pasien->delete();

    return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil dihapus.');
}
public function restoreView()
{
    $pasien = DataPasien::onlyTrashed()->get();
    return view('restore.restore_data_pasien', compact('pasien'));
}



public function restore($id)
{
    $pasien = DataPasien::onlyTrashed()->findOrFail($id);
    $pasien->restore();

    return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil direstore.');
}
}
