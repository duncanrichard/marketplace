<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EventKebutuhan extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'pengajuan_event_id',
        'nama',
        'jumlah',
        'tanggal',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(PengajuanEvent::class, 'pengajuan_event_id');
    }

    /**
     * Konfigurasi logging aktivitas
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // log semua kolom
            ->logOnlyDirty() // hanya jika data berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Data kebutuhan event telah {$eventName}");
    }
}