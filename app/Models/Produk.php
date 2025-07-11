<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\ProdukDetail; // ✅ Tambahkan ini

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kategori_id', 'harga', 'stok', 'deskripsi', 'foto', 'status_produk'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detail()
    {
        return $this->hasOne(ProdukDetail::class); // ✅ Sekarang ini tidak error
    }
}
