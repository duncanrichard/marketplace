<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPasien extends Model
{
    use SoftDeletes;

    protected $table = 'data_pasiens';

    protected $fillable = [
        'nama',
        'no_ktp',
        'no_cm',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'tanggal_pendaftaran',
        'alamat',
        'agama',
        'email',
        'status_pernikahan',
        'golongan_darah',
        'pendidikan',
        'pekerjaan',
        'keterangan',
        'catatan_pasien',
        'telat',
        'tidak_dilayani',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'nama_wali',
        'hubungan',
        'no_hp_wali',
        'alamat_wali',
        'foto',
        'no_member',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke tabel reservasis
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'pasien_id');
    }
}
