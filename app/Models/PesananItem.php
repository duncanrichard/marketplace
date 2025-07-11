<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $fillable = [
        'pesanan_id', 'produk_id', 'nama_produk', 'harga', 'qty', 'total'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
