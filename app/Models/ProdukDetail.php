<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'ukuran',
        'berat',
        'rasa',
        'warna',
        'merk',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
