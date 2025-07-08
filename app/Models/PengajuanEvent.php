<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PengajuanEvent extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'judul',
        'tanggal',
        'kategori',
        'status',
        'lokasi',
        'target',
        'jenis_target',
        'pic_nama',
        'pic_telp',
        'anggaran',
        'jumlah_tim',
        'deskripsi',
        'lampiran',
        'ttd',
        'id_brand'
    ];

    protected $casts = [
        'jenis_target' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()              // log semua field yang berubah
            ->logOnlyDirty()       // hanya log perubahan (bukan semua saat update)
            ->setDescriptionForEvent(fn(string $eventName) => "Pengajuan Event {$eventName}");
    }

    public function kebutuhan()
    {
        return $this->hasMany(EventKebutuhan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function praMembers()
    {
        return $this->hasMany(\App\Models\PraMember::class);
    }
}