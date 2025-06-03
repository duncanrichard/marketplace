@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Detail Data Pasien</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3">
            <a href="{{ route('data-pasien.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card shadow-sm rounded p-4 mb-4">
    <div class="row">
        <!-- Foto & Info Ringkas -->
        <div class="col-md-3 text-center border-end">
            <div class="border rounded mb-3" style="width: 160px; height: 200px; margin: auto;">
                @if($pasien->foto)
                    <img src="{{ asset($pasien->foto) }}" alt="Foto Pasien" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                        <span>Tidak Ada Foto</span>
                    </div>
                @endif
            </div>
            <h5 class="fw-bold">{{ $pasien->nama }}</h5>
            <span class="badge bg-primary">{{ $pasien->jenis_kelamin }}</span><br>
            <small class="text-muted">{{ $pasien->tempat_lahir }}, {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}</small><br>
            <span class="badge bg-primary">{{ $pasien->no_cm }}</span><br>
        </div>

        <!-- Detail Informasi -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">No KTP:</label>
                    <div>{{ $pasien->no_ktp }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">No HP / Email:</label>
                    <div>{{ $pasien->no_hp }} / {{ $pasien->email }}</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Alamat:</label>
                    <div>{{ $pasien->alamat }}, {{ $pasien->kota }}, {{ $pasien->provinsi }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Agama:</label>
                    <div>{{ $pasien->agama }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Status Pernikahan:</label>
                    <div>{{ $pasien->status_pernikahan }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Golongan Darah:</label>
                    <div>{{ $pasien->golongan_darah }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Pendidikan:</label>
                    <div>{{ $pasien->pendidikan }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Pekerjaan:</label>
                    <div>{{ $pasien->pekerjaan }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Tanggal Pendaftaran:</label>
                    <div>{{ \Carbon\Carbon::parse($pasien->tanggal_pendaftaran)->translatedFormat('d F Y') }}</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Keterangan:</label>
                    <div>{{ $pasien->keterangan ?? '-' }}</div>
                </div>
                <hr class="mt-4 mb-3">
<h6 class="fw-bold mb-2">Informasi Tambahan</h6>
<div class="row">
    <div class="col-md-12 mb-3">
        <label class="fw-bold">Catatan Khusus:</label>
        <div>{{ $pasien->catatan_pasien ?? '-' }}</div>
    </div>
    <div class="col-md-6 mb-2">
        <label class="fw-bold">Datang Telatan:</label>
        <div>
            @if ($pasien->telat)
                <span class="badge bg-warning text-dark">Ya</span>
            @else
                <span class="badge bg-success">Tidak</span>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label class="fw-bold">Status Dilayani:</label>
        <div>
            @if ($pasien->tidak_dilayani)
                <span class="badge bg-danger">Tidak Dilayani</span>
            @else
                <span class="badge bg-success">Dilayani</span>
            @endif
        </div>
    </div>
</div>

            </div>

            <hr class="mt-4 mb-3">
            <h6 class="fw-bold mb-2">Data Penanggung Jawab</h6>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Nama Wali:</label>
                    <div>{{ $pasien->nama_wali }}</div>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Hubungan / No HP:</label>
                    <div>{{ $pasien->hubungan }} / {{ $pasien->no_hp_wali }}</div>
                </div>
                <div class="col-md-12 mb-2">
                    <label class="fw-bold">Alamat Wali:</label>
                    <div>{{ $pasien->alamat_wali }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
