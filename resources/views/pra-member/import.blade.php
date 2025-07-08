@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30 mb-3">
    <h2>Import Pra Member Tanpa Event</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('import.pra-member.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">File Excel/CSV</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Format: <strong>nama, telepon, email (opsional), keterangan (opsional)</strong>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
</div>

<!-- TABEL DATA PRA MEMBER TANPA EVENT -->
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Data Pra Member Tanpa Event</h5>
        <div class="table-responsive">
            <table id="praMemberTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Keterangan</th>
                        <th>Tanggal Input</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($praMembers as $i => $pm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pm->nama }}</td>
                        <td>{{ $pm->telepon }}</td>
                        <td>{{ $pm->email ?? '-' }}</td>
                        <td>{{ $pm->keterangan ?? '-' }}</td>
                        <td>{{ $pm->created_at->translatedFormat('d F Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#praMemberTable').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
});
</script>
@endsection

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection