@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Pengajuan Event</h2>
            </div>
        </div>
        @if(auth()->user()->hasAccess('events', 'create'))
        <div class="col-md-6 text-end mb-3 d-flex justify-content-end gap-2">
            <a href="{{ route('events.create') }}" class="btn btn-primary">Pengajuan</a>
            <a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">Import
                Event</a>
        </div>
        @endif
    </div>
</div>

<div class="card-styles">
    <div class="card-style-3 mb-30">
        <div class="card-content">
            <ul class="nav nav-tabs mb-3">
                @foreach(['Pending', 'Confirmed', 'Ditolak'] as $s)
                <li class="nav-item">
                    <a class="nav-link {{ ($status ?? 'Pending') == $s ? 'active' : '' }}"
                        href="{{ route('events.submission', ['status' => $s]) }}">
                        {{ $s }}
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="table-wrapper table-responsive">
                <table id="pengajuanevent" class="table striped-table display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Event</th>
                            <th class="text-center">Tanggal Event</th>
                            <th class="text-center">Total Pra Member</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- PERULANGAN UNTUK BARIS TABEL --}}
                        @foreach($events as $event)
                        @php
                        $today = \Carbon\Carbon::now()->toDateString();
                        $eventDate = \Carbon\Carbon::parse($event->tanggal)->toDateString();
                        $isToday = $eventDate === $today;
                        $isExpired = $today > $eventDate;
                        @endphp
                        <tr class="{{ $isToday ? 'table-info' : '' }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $event->judul }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-center">{{ $event->pra_members_count ?? 0 }}</td>
                            <td class="text-center">
                                <span class="badge
                                    @if($event->status == 'Pending') bg-warning text-dark
                                    @elseif($event->status == 'Confirmed') bg-success
                                    @else bg-danger
                                    @endif">
                                    {{ $event->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="btn btn-info btn-sm">Detail</a>
                                    @if($event->status === 'Pending' && auth()->user()->hasAccess('events', 'edit'))
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editEventModal{{ $event->id }}">
                                        Edit
                                    </button>
                                    @endif

                                    @if($event->status === 'Confirmed' && auth()->user()->hasAccess('events', 'import'))
                                    {{-- Tombol pemicu modal tetap di sini --}}
                                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#importPraMemberModal{{ $event->id }}">
                                        Import Pra Member
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm pra-member-btn"
                                        data-url="{{ route('pra-member.show', $event->id) }}"
                                        data-expired="{{ $isExpired ? '1' : '0' }}">
                                        Daftar Pra Member
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        {{-- ❌ KODE MODAL DIHAPUS DARI SINI --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ====================================================================== --}}
{{-- ✅ SEMUA DEFINISI MODAL DIPINDAHKAN KE SINI (DI LUAR TABEL) --}}
{{-- ====================================================================== --}}

{{-- PERULANGAN BARU KHUSUS UNTUK MEMBUAT MODAL IMPORT PRA MEMBER --}}
@foreach($events as $event)
<div class="modal fade" id="importPraMemberModal{{ $event->id }}" tabindex="-1"
    aria-labelledby="importPraMemberLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('events.pra-members.import', $event->id) }}" method="POST" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importPraMemberLabel{{ $event->id }}">
                    Import Pra Member – {{ $event->judul }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="importFile-{{ $event->id }}" class="form-label">File Excel (.xlsx)</label>
                    <input type="file" name="file" class="form-control" id="importFile-{{ $event->id }}" accept=".xlsx"
                        required>
                </div>
                <small class="text-muted">
                    Pastikan file Excel memiliki kolom: <code>nama</code>, <code>telepon</code>, <code>email</code>,
                    <code>keterangan</code>
                </small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Import</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
@endforeach


{{-- 🔔 Modal untuk Event yang Sudah Berakhir --}}
<div class="modal fade" id="eventExpiredModal" tabindex="-1" aria-labelledby="eventExpiredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="eventExpiredLabel">Event Telah Berakhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Maaf, Anda tidak dapat mengakses formulir Pra Member karena event sudah selesai.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- 📥 Modal Import Event --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Event dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx" required>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Gunakan kolom: <code>judul</code>, <code>tanggal</code>,
                        <code>kategori</code>, <code>status</code>, <code>lokasi</code>, <code>jumlah_tim</code>,
                        <code>id_brand</code></small>
                </div>
                <div class="border rounded p-2">
                    <strong>Daftar Brand (ID → Nama):</strong>
                    <ul class="mb-0 small">
                        @forelse($brands as $brand)
                        <li><code>{{ $brand->id }}</code> → {{ $brand->nama }}</li>
                        @empty
                        <li class="text-danger">Belum ada data brand tersedia.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

@foreach($events as $event)
@if($event->status === 'Pending')
<div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1"
    aria-labelledby="editEventLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            @method('PATCH')

            <div class="modal-header">
                <h5 class="modal-title" id="editEventLabel{{ $event->id }}">Edit Event – {{ $event->judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- Informasi Dasar --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Event</label>
                        <input type="text" name="judul" class="form-control" value="{{ $event->judul }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Event</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $event->tanggal }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kategori / Jenis Campaign</label>
                        <input type="text" name="kategori" class="form-control" value="{{ $event->kategori }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $event->lokasi }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Tim</label>
                        <input type="number" name="jumlah_tim" class="form-control" value="{{ $event->jumlah_tim }}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Brand</label>
                        <select name="id_brand" class="form-select" required>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $event->id_brand == $brand->id ? 'selected' : '' }}>
                                {{ $brand->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">PIC</label>
                        <input type="text" name="pic_nama" class="form-control" value="{{ $event->pic_nama }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telepon PIC</label>
                        <input type="text" name="pic_telp" class="form-control" value="{{ $event->pic_telp }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Anggaran</label>
                        <input type="number" name="anggaran" class="form-control" value="{{ $event->anggaran }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Target Peserta</label>
                        <input type="number" name="target" class="form-control" value="{{ $event->target }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $event->deskripsi }}</textarea>
                </div>

                <hr>
                <h5>Kebutuhan Event</h5>
                <div id="edit-kebutuhan-container-{{ $event->id }}">
                    @foreach($event->kebutuhan as $i => $item)
                    <div class="row kebutuhan-item mb-2">
                        <input type="hidden" name="kebutuhan[{{ $i }}][id]" value="{{ $item->id }}">

                        <div class="col-md-3">
                            <input type="text" name="kebutuhan[{{ $i }}][nama]" class="form-control"
                                value="{{ $item->nama }}" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="kebutuhan[{{ $i }}][jumlah]" class="form-control"
                                value="{{ $item->jumlah }}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="kebutuhan[{{ $i }}][tanggal]" class="form-control"
                                value="{{ $item->tanggal }}" required>
                        </div>
                        <div class="col-md-2">
                            <select name="kebutuhan[{{ $i }}][status]" class="form-select" required>
                                <option value="Beli" {{ $item->status == 'Beli' ? 'selected' : '' }}>Beli</option>
                                <option value="Pinjam" {{ $item->status == 'Pinjam' ? 'selected' : '' }}>Pinjam</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-kebutuhan w-100">&times;</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addKebutuhanRow({{ $event->id }})">
                    + Tambah Kebutuhan
                </button>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
@endif
@endforeach


@endsection

@section('scripts')
{{-- (Tidak ada perubahan di sini) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#pengajuanevent').DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        searching: true
    });

    $('.pra-member-btn').click(function() {
        const isExpired = $(this).data('expired') == '1';
        const url = $(this).data('url');

        if (isExpired) {
            const modal = new bootstrap.Modal(document.getElementById('eventExpiredModal'));
            modal.show();
        } else {
            window.open(url, '_blank');
        }
    });
});

let kebutuhanIndex = 1000; // Awal index yang aman

function addKebutuhanRow(eventId) {
    const container = document.getElementById(`edit-kebutuhan-container-${eventId}`);
    const row = document.createElement('div');
    row.classList.add('row', 'kebutuhan-item', 'mb-2');

    row.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="kebutuhan[${kebutuhanIndex}][nama]" class="form-control" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="kebutuhan[${kebutuhanIndex}][jumlah]" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="date" name="kebutuhan[${kebutuhanIndex}][tanggal]" class="form-control" required>
        </div>
        <div class="col-md-2">
            <select name="kebutuhan[${kebutuhanIndex}][status]" class="form-select" required>
                <option value="Beli">Beli</option>
                <option value="Pinjam">Pinjam</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-kebutuhan w-100">&times;</button>
        </div>
    `;

    container.appendChild(row);

    row.querySelector('.remove-kebutuhan').addEventListener('click', function() {
        row.remove();
    });

    kebutuhanIndex++;
}
</script>
@endsection

@section('styles')
{{-- (Tidak ada perubahan di sini) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
{{-- CSS HACK SUDAH TIDAK DIPERLUKAN LAGI KARENA STRUKTUR HTML SUDAH BENAR --}}
@endsection