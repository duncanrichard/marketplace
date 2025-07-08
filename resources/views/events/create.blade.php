@extends('layouts.app')

@section('styles')
<style>
.campaign-option:hover {
    background-color: #f0f0f0;
    cursor: pointer;
}

.form-label {
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Tambah Event</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3">
            <a href="{{ route('events.submission') }}" class="btn btn-secondary">Kembali ke Daftar Event</a>
        </div>
    </div>
</div>

<div class="card-style-3 mb-30">
    <div class="card-content">
        {{-- Tampilkan Error --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="status" value="Pending">

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nama Event <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Event <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal') }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dibuat oleh</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <select name="id_brand" class="form-select @error('id_brand') is-invalid @enderror" required>
                        <option value="">-- Pilih Brand --</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('id_brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Jenis Campaign <span class="text-danger">*</span></label>
                    <input type="text" name="kategori" id="kategori"
                        class="form-control @error('kategori') is-invalid @enderror" placeholder="Klik untuk memilih"
                        readonly required>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status Pengajuan</label>
                    <div>
                        <span class="badge bg-warning text-dark fs-4 py-2 px-3">Pending</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                    value="{{ old('lokasi') }}" required>
                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Target Jumlah Peserta</label>
                    <input type="number" name="target" class="form-control" value="{{ old('target') }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Target</label><br>
                    @foreach(['Orang', 'Perusahaan', 'Komunitas'] as $target)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="jenis_target[]" value="{{ $target }}"
                            {{ is_array(old('jenis_target')) && in_array($target, old('jenis_target')) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $target }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama PIC Event</label>
                    <input type="text" name="pic_nama" class="form-control" value="{{ old('pic_nama') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon PIC Event</label>
                    <input type="text" name="pic_telp" class="form-control" value="{{ old('pic_telp') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Anggaran (Opsional)</label>
                    <input type="number" name="anggaran" class="form-control" value="{{ old('anggaran') }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jumlah Tim / Personel <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah_tim"
                        class="form-control @error('jumlah_tim') is-invalid @enderror" value="{{ old('jumlah_tim') }}"
                        required min="0">
                    @error('jumlah_tim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi / Tujuan Event</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Proposal / Lampiran</label>
                <input type="file" name="lampiran" class="form-control">
            </div>

            <hr class="my-4">
            <h5>Kebutuhan Event</h5>
            <div id="kebutuhan-container"></div>

            <template id="kebutuhan-template">
                <div class="row kebutuhan-item mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="kebutuhan[__INDEX__][nama]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="kebutuhan[__INDEX__][jumlah]" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Request <span class="text-danger">*</span></label>
                        <input type="date" name="kebutuhan[__INDEX__][tanggal]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="kebutuhan[__INDEX__][status]" class="form-select" required>
                            <option value="Beli">Beli</option>
                            <option value="Pinjam">Pinjam</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-kebutuhan w-100">&times;</button>
                    </div>
                </div>
            </template>

            <div class="mb-3">
                <button type="button" class="btn btn-primary" id="add-kebutuhan">+ Tambah Kebutuhan</button>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-send me-1"></i> Ajukan Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Campaign -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Jenis Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <table id="campaigns-table-modal" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th class="text-center">Nama Campaign</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $index => $item)
                        <tr class="campaign-option" data-value="{{ $item }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriInput = document.getElementById('kategori');
    const campaignModal = new bootstrap.Modal(document.getElementById('campaignModal'), {
        backdrop: 'static'
    });

    // Show modal when input clicked
    kategoriInput.addEventListener('click', function() {
        campaignModal.show();
    });

    // Initialize DataTable
    $('#campaigns-table-modal').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        responsive: true,
        language: {
            searchPlaceholder: "Cari campaign...",
            search: "",
            zeroRecords: "Tidak ditemukan.",
            paginate: {
                next: '›',
                previous: '‹'
            }
        }
    });

    // Select campaign
    $('#campaigns-table-modal').on('click', '.campaign-option', function() {
        kategoriInput.value = this.dataset.value;
        campaignModal.hide();
    });

    // Dynamic kebutuhan
    let index = 0;
    const addButton = document.getElementById('add-kebutuhan');
    const container = document.getElementById('kebutuhan-container');
    const template = document.getElementById('kebutuhan-template').innerHTML;

    addButton.addEventListener('click', function() {
        const html = template.replace(/__INDEX__/g, index++);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        container.appendChild(wrapper);

        wrapper.querySelector('.remove-kebutuhan').addEventListener('click', function() {
            wrapper.remove();
        });
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!kategoriInput.value.trim()) {
            e.preventDefault();
            alert('Silakan pilih jenis campaign terlebih dahulu.');
        }
    });
});
</script>
@endsection