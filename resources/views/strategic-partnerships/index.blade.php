@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Daftar Kerjasama Strategis</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3 d-flex justify-content-end gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                + Tambah Kerjasama
            </button>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                Import Excel
            </button>

        </div>
    </div>
</div>


<div class="card-style-3 mb-30">
    <div class="card-content">
        <div class="table-wrapper table-responsive">
            <table class="table table-bordered" id="partnerships-table">
                <thead>
                    <tr>
                        <th class="text-center" class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Marketing</th>
                        <th class="text-center">PIC</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Selesai</th>
                        <th class="text-center">Dokumen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $item->kode_kerjasama }}</td>
                        <td class="text-center">{{ $item->nama_kerjasama }}</td>
                        <td class="text-center">{{ $item->nama_marketing }}</td>
                        <td class="text-center">{{ $item->nama_pic }} ({{ $item->telepon_pic }})</td>
                        <td class="text-center">{{ $item->tanggal_kerjasama }}</td>
                        <td class="text-center">{{ $item->tanggal_selesai }}</td>
                        <td class="text-center">
                            @if($item->dokumen)
                            <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">Lihat</a>
                            @else
                            <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('strategic-partnerships.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kerjasama -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('strategic-partnerships.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Kerjasama Strategis</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Kerjasama</label>
                        <input type="text" name="kode_kerjasama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Kerjasama</label>
                        <input type="text" name="nama_kerjasama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kerjasama</label>
                        <input type="date" name="tanggal_kerjasama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Marketing</label>
                        <input type="text" name="nama_marketing" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="nama_pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No Telepon PIC</label>
                        <input type="text" name="telepon_pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload Dokumen (PDF, JPG, PNG)</label>
                        <input type="file" name="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('strategic-partnerships.import') }}" method="POST" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Import Kerjasama Strategis</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file" class="form-label">File Excel (.xlsx)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx" required>
                </div>
                <small class="text-muted">Gunakan kolom: <code>kode_kerjasama</code>, <code>nama_kerjasama</code>,
                    <code>tanggal_kerjasama</code>, <code>tanggal_selesai</code>, <code>nama_marketing</code>,
                    <code>nama_pic</code>, <code>telepon_pic</code></small>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Import</button>
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#partnerships-table').DataTable();
});
</script>
@endsection