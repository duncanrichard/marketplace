<?php

namespace App\Imports;

use App\Models\PraMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PraMemberImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama']) || empty($row['telepon'])) {
            return null;
        }

        return new PraMember([
            'pengajuan_event_id' => null,
            'nama'               => $row['nama'],
            'telepon'            => $row['telepon'],
            'email'              => $row['email'] ?? null,
            'keterangan'         => $row['keterangan'] ?? null,
        ]);
    }
}