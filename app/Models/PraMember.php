<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PraMember extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'pengajuan_event_id',
        'nama',
        'telepon',
        'email',
        'keterangan',
    ];

    public function event()
    {
        return $this->belongsTo(PengajuanEvent::class, 'pengajuan_event_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()              // log semua field
            ->logOnlyDirty()       // hanya yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "PraMember {$eventName}");
    }
}