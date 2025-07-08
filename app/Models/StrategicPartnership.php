<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StrategicPartnership extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'kode_kerjasama',
        'nama_kerjasama',
        'tanggal_kerjasama',
        'tanggal_selesai',
        'nama_marketing',
        'nama_pic',
        'telepon_pic',
        'dokumen',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('strategic_partnership')
            ->setDescriptionForEvent(fn(string $event) =>
            "Kerjasama Strategis {$this->nama_kerjasama} telah {$event}");
    }
}
