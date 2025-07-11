@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
  <div class="row align-items-center">
    <div class="col-md-6">
      <div class="title mb-30">
        <h2>Kategori Barang</h2>
      </div>
    </div>
    <div class="col-md-6 text-end mb-3 d-flex justify-content-end gap-2">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
        + Tambah Kategori
      </button>
    </div>
  </div>
</div>


<div class="card-style-3 mb-30">
  <div class="card-content">
    <div class="table-wrapper table-responsive">
      <table class="table table-bordered" id="kategori-table">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Deskripsi</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kategoris as $index => $kategori)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $kategori->nama }}</td>
            <td class="text-center">{{ $kategori->deskripsi }}</td>
            <td class="text-center">
              <button type="button"
                class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#editKategoriModal"
                data-id="{{ $kategori->id }}"
                data-nama="{{ $kategori->nama }}"
                data-deskripsi="{{ $kategori->deskripsi }}">
                Edit
              </button>

              <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('kategori.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Kategori</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Kategori</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editForm" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Edit Kategori</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Kategori</label>
          <input type="text" name="nama" id="editNama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" id="editDeskripsi" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="submit">Update</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
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
  $(document).ready(function () {
    $('#kategori-table').DataTable();

    $('#editKategoriModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget)
      const id = button.data('id')
      const nama = button.data('nama')
      const deskripsi = button.data('deskripsi')

      const modal = $(this)
      modal.find('#editNama').val(nama)
      modal.find('#editDeskripsi').val(deskripsi)
      modal.find('#editForm').attr('action', `/c-panel/kategori/${id}`)
    })
  })
</script>
@endsection
