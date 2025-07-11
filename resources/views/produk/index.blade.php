@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
  <div class="row align-items-center">
    <div class="col-md-6">
      <div class="title mb-30">
        <h2>Master Produk</h2>
      </div>
    </div>
    <div class="col-md-6 text-end mb-3 d-flex justify-content-end gap-2">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProdukModal">
        + Tambah Produk
      </button>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card-style-3 mb-30">
  <div class="card-content">
    <div class="table-wrapper table-responsive">
      <table class="table table-bordered" id="produk-table">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($produks as $index => $produk)
          <tr class="clickable-row" data-id="{{ $produk->id }}">

            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">
              @if($produk->foto)
              <img src="{{ asset('storage/' . $produk->foto) }}" width="70" height="70" style="object-fit:cover;">
              @else
              <span class="text-muted">-</span>
              @endif
            </td>
            <td class="text-center">{{ $produk->nama }}</td>
            <td class="text-center">{{ $produk->kategori->nama }}</td>
            <td class="text-center">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
            <td class="text-center">{{ $produk->stok }}</td>
           <td class="text-center no-detail">
              <button class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#editProdukModal"
                data-id="{{ $produk->id }}"
                data-nama="{{ $produk->nama }}"
                data-kategori="{{ $produk->kategori_id }}"
                data-harga="{{ $produk->harga }}"
                data-deskripsi="{{ $produk->deskripsi }}">
                Edit
              </button>

              <form action="{{ route('produk.destroy', $produk) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProdukModal" tabindex="-1" aria-labelledby="addProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Produk</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Produk</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori</label>
          <select name="kategori_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga</label>
          <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Stok</label>
          <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="col-md-6">
  <label class="form-label">Status Produk</label>
  <select name="status_produk" class="form-select" required>
    <option value="aktif" selected>Aktif</option>
    <option value="tidak_aktif">Tidak Aktif</option>
  </select>
</div>

{{-- Detail Produk --}}
<div class="col-md-6">
  <label class="form-label">Ukuran</label>
  <input type="text" name="detail_ukuran" class="form-control">
</div>
<div class="col-md-6">
  <label class="form-label">Berat (gram)</label>
  <input type="text" name="detail_berat" class="form-control">
</div>
<div class="col-md-6">
  <label class="form-label">Rasa</label>
  <input type="text" name="detail_rasa" class="form-control">
</div>
<div class="col-md-6">
  <label class="form-label">Warna</label>
  <input type="text" name="detail_warna" class="form-control">
</div>
<div class="col-md-6">
  <label class="form-label">Merk</label>
  <input type="text" name="detail_merk" class="form-control">
</div>

<div class="col-md-12">
  <label class="form-label">Deskripsi Produk</label>
  <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi produk..."></textarea>
</div>
        <div class="col-md-12">
          <label class="form-label">Foto Produk</label>
          <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editFormProduk" enctype="multipart/form-data" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Produk</label>
          <input type="text" name="nama" id="editNama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori</label>
          <select name="kategori_id" id="editKategori" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga</label>
          <input type="number" name="harga" id="editHarga" class="form-control" required>
        </div>
        <div class="col-md-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" id="editDeskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-12">
          <label class="form-label">Ganti Foto Produk (Opsional)</label>
          <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="submit">Update</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="detailProdukModal" tabindex="-1" aria-labelledby="detailProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Detail Produk</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailProdukContent">
        <p class="text-center text-muted">Memuat data...</p>
      </div>
    </div>
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
    // ✅ Inisialisasi DataTable
    $('#produk-table').DataTable();

    // ✅ Show Modal Edit Produk
    $('#editProdukModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const id = button.data('id');
      const nama = button.data('nama');
      const kategori = button.data('kategori');
      const harga = button.data('harga');
      const deskripsi = button.data('deskripsi');

      const modal = $(this);
      modal.find('#editNama').val(nama);
      modal.find('#editKategori').val(kategori);
      modal.find('#editHarga').val(harga);
      modal.find('#editDeskripsi').val(deskripsi);
      modal.find('#editFormProduk').attr('action', `/c-panel/produk/${id}`);
    });

    // ✅ Show Modal Detail Produk saat klik baris (kecuali kolom aksi)
    $('#produk-table tbody').on('click', 'tr', function (e) {
      if ($(e.target).closest('td').hasClass('no-detail')) return;

      const id = $(this).data('id');
      if (!id) return;

      const modal = new bootstrap.Modal(document.getElementById('detailProdukModal'));
      $('#detailProdukContent').html('<p class="text-muted text-center">Memuat data...</p>');
      modal.show();

      fetch(`/produk/${id}`)
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            $('#detailProdukContent').html('<div class="alert alert-danger">Produk tidak ditemukan.</div>');
            return;
          }

          const p = data.produk;
          const d = p.detail || {};

          const html = `
            <div class="row">
              <div class="col-md-4 text-center">
                <img src="${p.gambar}" class="img-fluid rounded shadow-sm" alt="${p.nama}">
              </div>
              <div class="col-md-8">
                <h5 class="text-success">${p.nama}</h5>
                <p><strong>Kategori:</strong> ${p.kategori}</p>
                <p><strong>Harga:</strong> Rp ${Number(p.harga).toLocaleString()}</p>
                <p><strong>Deskripsi:</strong> ${p.deskripsi ?? '<em>Tidak ada deskripsi</em>'}</p>
                <hr>
                <p><strong>Ukuran:</strong> ${d.ukuran ?? '-'}</p>
                <p><strong>Berat:</strong> ${d.berat ?? '-'}</p>
                <p><strong>Rasa:</strong> ${d.rasa ?? '-'}</p>
                <p><strong>Warna:</strong> ${d.warna ?? '-'}</p>
                <p><strong>Merk:</strong> ${d.merk ?? '-'}</p>
              </div>
            </div>
          `;
          $('#detailProdukContent').html(html);
        })
        .catch(() => {
          $('#detailProdukContent').html('<div class="alert alert-danger">Terjadi kesalahan saat mengambil data.</div>');
        });
    });
  });
</script>
@endsection
