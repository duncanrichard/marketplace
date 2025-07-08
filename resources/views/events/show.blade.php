@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center justify-content-between">
        <div class="col">
            <h2 class="mb-3">Detail Pengajuan Event</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('events.submission') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>

<div class="card-style-3 mb-30">
    <div class="card-content">

        {{-- Feedback --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Informasi Event --}}
        <div class="row mb-4">
            @php
            $statusBadge = match($event->status) {
            'Pending' => '<span class="badge bg-warning text-dark">Pending</span>',
            'Confirmed' => '<span class="badge bg-success">Confirmed</span>',
            'Ditolak' => '<span class="badge bg-danger">Ditolak</span>',
            default => '<span class="badge bg-secondary">' . e($event->status) . '</span>',
            };

            $targetPeserta = ($event->target ?? '-') . ($event->jenis_target ? ', ' . implode(', ',
            $event->jenis_target) : '');

            $info = [
            'Nama Event' => e($event->judul),
            'Tanggal Event' => \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y'),
            'Jenis Campaign' => e($event->kategori),
            'Brand' => e(optional($event->brand)->nama ?? '-'),
            'Status' => $statusBadge,
            'Lokasi' => e($event->lokasi),
            'Target Peserta' => $targetPeserta,
            'Jumlah Tim' => e($event->jumlah_tim),
            'Nama PIC' => e($event->pic_nama ?? '-'),
            'Telepon PIC' => e($event->pic_telp ?? '-'),
            'Anggaran' => $event->anggaran ? 'Rp' . number_format($event->anggaran, 0, ',', '.') : '-',
            'Lampiran' => $event->lampiran
            ? '<a href="' . asset('storage/' . $event->lampiran) . '" target="_blank"
                class="btn btn-sm btn-outline-primary">📄 Lihat File</a>'
            : '<span class="text-muted">Tidak ada file</span>',
            'Dibuat oleh' => e(optional($event->user)->name ?? '-'),
            ];
            @endphp

            @foreach($info as $label => $value)
            <div class="col-md-6 mb-2 d-flex">
                <div style="width: 160px;"><strong>{{ $label }}</strong></div>
                <div style="width: 10px;">:</div>
                <div>{!! $value !!}</div>
            </div>
            @endforeach
        </div>

        @if($event->ttd)
        <div class="mb-4">
            <div class="d-flex">
                <div style="width: 160px;"><strong>Tanda Tangan</strong></div>
                <div style="width: 10px;">:</div>
                <div>
                    <img src="{{ asset('storage/' . $event->ttd) }}" alt="Tanda Tangan"
                        style="max-width: 300px; border:1px solid #ccc; padding:5px;">
                </div>
            </div>
        </div>
        @endif

        @if($event->deskripsi)
        <div class="mb-4">
            <div class="d-flex">
                <div style="width: 160px;"><strong>Deskripsi / Tujuan</strong></div>
                <div style="width: 10px;">:</div>
                <div class="text-muted">{{ $event->deskripsi }}</div>
            </div>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        @if(Auth::user()->role === 'manager' && $event->status === 'Pending')
        <div class="mb-4">
            <form action="{{ route('events.updateStatus', $event->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="Confirmed">
                <button type="submit" class="btn btn-success me-2">✅ Confirm</button>
            </form>

            <form action="{{ route('events.updateStatus', $event->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="Ditolak">
                <button type="submit" class="btn btn-danger">❌ Tolak</button>
            </form>
        </div>
        @endif

        <hr>

        {{-- Tabel Kebutuhan --}}
        <h5 class="mb-3">Kebutuhan Event</h5>
        <div class="table-wrapper table-responsive">
            <table id="pengajuanevent" class="table table-striped display nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Request</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->kebutuhan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'Beli' ? 'bg-info' : 'bg-secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tabel Pra Member --}}
        @if($event->praMembers->count())
        <h5 class="mb-3 mt-5">Daftar Pra Member</h5>
        <div class="table-wrapper table-responsive">
            <table id="tablePraMember" class="table table-striped table-bordered display nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->praMembers as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $member->nama }}</td>
                        <td>{{ $member->telepon }}</td>
                        <td>{{ $member->email ?? '-' }}</td>
                        <td>{{ $member->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h5 class="mt-5">Daftar Pra Member</h5>
        <p class="text-muted">Belum ada data pra member untuk event ini.</p>
        @endif
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#pengajuanevent').DataTable({
        responsive: true,
        paging: true,
        searching: false,
        ordering: false,
        info: false
    });

    $('#tablePraMember').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Tidak ada data tersedia",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });
});
</script>
@endsection