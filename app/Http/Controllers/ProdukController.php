<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukDetail; 
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all(); // ← Tambahkan ini agar tersedia untuk dropdown
        return view('produk.index', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'deskripsi' => 'nullable|string',
        'status_produk' => 'required|in:aktif,tidak_aktif',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $fotoPath = null;

    if ($request->hasFile('foto')) {
        $namaFile = str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->foto->extension();
        $fotoPath = $request->file('foto')->storeAs('public/produk', $namaFile);
        $fotoPath = str_replace('public/', '', $fotoPath);
    }

    $produk = Produk::create([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
        'status_produk' => $request->status_produk,
    ]);

    // Simpan detail produk jika diisi
if ($request->filled(['detail_ukuran', 'detail_berat', 'detail_rasa', 'detail_warna', 'detail_merk'])) {
    ProdukDetail::create([
        'produk_id' => $produk->id,
        'ukuran'    => $request->detail_ukuran,
        'berat'     => $request->detail_berat,
        'rasa'      => $request->detail_rasa,
        'warna'     => $request->detail_warna,
        'merk'      => $request->detail_merk,
    ]);
}


    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
}
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'harga' => 'required|numeric',
        'stok' => 'nullable|integer',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $produk = Produk::findOrFail($id);

    $fotoPath = $produk->foto;

    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($fotoPath) {
            Storage::delete('public/' . $fotoPath);
        }

        $namaFile = str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->foto->extension();
        $fotoPath = $request->file('foto')->storeAs('public/produk', $namaFile);
        $fotoPath = str_replace('public/', '', $fotoPath); // simpan path relatif
    }

    $produk->update([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id,
        'harga' => $request->harga,
        'stok' => $request->stok ?? $produk->stok,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
    ]);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
}


public function show($id)
{
    $produk = Produk::with(['kategori', 'detail'])->find($id);

    if (!$produk) {
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success' => true,
        'produk' => [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'kategori' => $produk->kategori->nama ?? '-',
            'harga' => $produk->harga,
            'deskripsi' => $produk->deskripsi,
            'gambar' => $produk->foto ? asset('storage/' . $produk->foto) : asset('images/default-product.jpg'),
            'detail' => $produk->detail
        ]
    ]);
}

}
