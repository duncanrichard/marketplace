<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Kategori;
use App\Models\ProdukDetail;



class TokoController extends Controller
{
  public function index(Request $request)
{
    $query = Produk::with('kategori')
                ->where('status_produk', 'aktif'); // ✅ Tambah kondisi status aktif

    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    if ($request->filled('min')) {
        $query->where('harga', '>=', $request->min);
    }

    if ($request->filled('max')) {
        $query->where('harga', '<=', $request->max);
    }

    $produks = $query->paginate(9)->withQueryString();
    $kategoris = Kategori::all(); // ambil semua kategori

    return view('toko.dashboard', compact('produks', 'kategoris'));
}


public function checkout()
{
    return view('toko.checkout');
}

public function prosesCheckout(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'telepon' => 'required|string|max:20',
        'alamat' => 'required|string',
        'metode' => 'required|string',
        'items' => 'required|json',
        'kode_booking' => 'required|string',
        'tanggal_order' => 'required|string',
        'tanggal_pengiriman' => 'nullable|date',
    ]);

    $items = json_decode($request->items, true);

        $pesanan = Pesanan::create([
    'kode_booking'       => $request->kode_booking,
    'tanggal_order'      => now()->format('Y-m-d'),
    'tanggal_pengiriman' => $request->tanggal_pengiriman,
    'nama'               => $request->nama,
    'telepon'            => $request->telepon,
    'alamat'             => $request->alamat,
    'metode'             => $request->metode,
    'status'             => 'Pesanan Di Proses', // ✅ status otomatis
]);

    foreach ($items as $item) {
        PesananItem::create([
            'pesanan_id'  => $pesanan->id,
            'produk_id'   => $item['id'] ?? null,
            'nama_produk' => $item['name'],
            'harga'       => $item['price'],
            'qty'         => $item['qty'],
            'total'       => $item['qty'] * $item['price'],
        ]);
    }

    return redirect('/')->with('success', 'Pesanan Anda telah diterima! Kami akan segera menghubungi Anda.')
                        ->with('clear_cart', true);
}

public function formCekPesanan()
{
    return view('toko.cek_pesanan'); // buat view ini
}

public function cariPesanan(Request $request)
{
    $request->validate([
        'kode_booking' => 'required|string'
    ]);

    $pesanan = Pesanan::with('items')->where('kode_booking', $request->kode_booking)->first();

    if (!$pesanan) {
        return response()->json([
            'success' => false,
            'message' => 'Pesanan tidak ditemukan.'
        ]);
    }

    return response()->json([
        'success' => true,
        'pesanan' => [
            'nama'            => $pesanan->nama,
            'telepon'         => $pesanan->telepon,
            'alamat'          => $pesanan->alamat,
            'tanggal_order'   => $pesanan->tanggal_order,
            'status'          => $pesanan->status,


        ],
        'items' => $pesanan->items->map(function($item) {
            return [
                'nama_produk' => $item->nama_produk,
                'qty'         => $item->qty,
                'total'       => $item->total,
            ];
        })
    ]);
}

public function getProduk($id)
{
    $produk = \App\Models\Produk::with('kategori')->find($id);

    if (!$produk) {
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success' => true,
        'produk' => [
            'id'        => $produk->id,
            'nama'      => $produk->nama,
            'harga'     => $produk->harga,
            'deskripsi' => $produk->deskripsi,
            'kategori'  => $produk->kategori->nama ?? '-',
            'gambar'    => $produk->foto 
                            ? asset('storage/' . $produk->foto)
                            : asset('images/default-product.jpg'),
        ]
    ]);
}
public function show($id)
{
    $produk = Produk::with(['kategori', 'detail'])->find($id);

    if (!$produk) {
        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.']);
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
