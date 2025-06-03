<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis'; // pastikan sesuai dengan nama tabel
    protected $fillable = [
        'pasien_id',
        'tanggal_reservasi',
        'jam_reservasi',
        'jam_kedatangan', 
        'status_reservasi',
        'catatan',
    ];

    public function pasien()
    {
        return $this->belongsTo(DataPasien::class, 'pasien_id');
    }
}
