<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Notifikasi extends Model
{
    use LogsActivity;

    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'pesan',
        'dibaca',
        'url',
    ];

    public $timestamps = true;

    /**
     * Konfigurasi logging aktivitas.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // log semua kolom yang diisi
            ->logOnlyDirty() // hanya log jika data berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Notifikasi {$eventName}");
    }
}