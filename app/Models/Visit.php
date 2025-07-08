<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Visit extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'nama_kunjungan',
        'lokasi_kunjungan',
        'pic',
        'no_pic',
        'tanggal_kunjungan',
        'file_path',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Konfigurasi log aktivitas
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('visit')
            ->setDescriptionForEvent(
                fn(string $eventName) =>
                "Kunjungan {$this->nama_kunjungan} telah {$eventName}"
            );
    }
}