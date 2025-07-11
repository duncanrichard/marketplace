<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'kode_booking', 'tanggal_order', 'tanggal_pengiriman',
        'nama', 'telepon', 'alamat', 'metode',  'status', 
    ];

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }
}
