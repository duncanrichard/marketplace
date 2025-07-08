@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Daftar Kunjungan Marketing</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3 d-flex justify-content-end gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitModal">
                + Tambah Kunjungan
            </button>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importVisitModal">
                Import Excel
            </button>
        </div>

    </div>
</div>


<div class="card-style-3 mb-30">
    <div class="card-content">
        <div class="table-wrapper table-responsive">
            <table id="visits-table" class="table striped-table display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kunjungan</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">PIC</th>
                        <th class="text-center">No PIC</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($visits as $index => $visit)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $visit->nama_kunjungan }}</td>
                        <td class="text-center">{{ $visit->lokasi_kunjungan }}</td>
                        <td class="text-center">{{ $visit->pic }}</td>
                        <td class="text-center">{{ $visit->no_pic }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($visit->tanggal_kunjungan)->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            @if($visit->file_path)
                            <a href="{{ asset('storage/' . $visit->file_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">Lihat File</a>
                            @else
                            <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('visits.destroy', $visit->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kunjungan -->
<div class="modal fade" id="addVisitModal" tabindex="-1" aria-labelledby="addVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('visits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Kunjungan Marketing</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Kunjungan</label>
                        <input type="text" name="nama_kunjungan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Kunjungan</label>
                        <input type="text" name="lokasi_kunjungan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No PIC</label>
                        <input type="text" name="no_pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload File (JPG, PNG, PDF)</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kunjungan -->
<div class="modal fade" id="editVisitModal" tabindex="-1" aria-labelledby="editVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editVisitForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Kunjungan Marketing</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" id="edit-id">
                    <div class="col-md-6">
                        <label class="form-label">Nama Kunjungan</label>
                        <input type="text" name="nama_kunjungan" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Kunjungan</label>
                        <input type="text" name="lokasi_kunjungan" id="edit-lokasi" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="pic" id="edit-pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No PIC</label>
                        <input type="text" name="no_pic" id="edit-no-pic" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" id="edit-tanggal" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ganti File (JPG, PNG, PDF)</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import Kunjungan -->
<div class="modal fade" id="importVisitModal" tabindex="-1" aria-labelledby="importVisitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('visits.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Import Kunjungan dari Excel</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx" required>
                </div>
                <div class="text-muted small">
                    Format Excel: <code>nama_kunjungan</code>, <code>lokasi_kunjungan</code>, <code>pic</code>,
                    <code>no_pic</code>, <code>tanggal_kunjungan</code>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="submit">Import</button>
                <button class="btn btn-outline-dark" type="button" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#visits-table').DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        searching: true
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#visits-table tbody').on('click', 'tr', function() {
        const row = $(this).closest('tr');
        const id = row.find('form').attr('action').split('/').pop();

        $('#edit-nama').val(row.find('td:nth-child(2)').text().trim());
        $('#edit-lokasi').val(row.find('td:nth-child(3)').text().trim());
        $('#edit-pic').val(row.find('td:nth-child(4)').text().trim());
        $('#edit-no-pic').val(row.find('td:nth-child(5)').text().trim());

        const tgl = row.find('td:nth-child(6)').text().trim();
        const parts = tgl.split(" ");
        const monthMap = {
            Jan: '01',
            Feb: '02',
            Mar: '03',
            Apr: '04',
            May: '05',
            Jun: '06',
            Jul: '07',
            Aug: '08',
            Sep: '09',
            Oct: '10',
            Nov: '11',
            Dec: '12'
        };
        const formattedDate = `${parts[2]}-${monthMap[parts[1]]}-${parts[0]}`;
        $('#edit-tanggal').val(formattedDate);

        const action = `/c-panel/visits/${id}`;
        $('#editVisitForm').attr('action', action);

        const modal = new bootstrap.Modal(document.getElementById('editVisitModal'));
        modal.show();
    });
});
</script>
@endsection