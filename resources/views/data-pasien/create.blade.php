@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>{{ __('Tambah Data Pasien') }}</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3">
            <a href="{{ route('data-pasien.index') }}" class="btn btn-secondary">Kembali ke Daftar Pasien</a>
        </div>
    </div>
</div>

<div class="card-style-3 mb-30">
    <div class="card-content">
            <form action="{{ route('data-pasien.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="foto" class="form-label">Upload Foto Pasien</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">
                    </div>
                    <div class="col-md-6 text-center">
                        <label class="form-label d-block">Preview Foto</label>
                        <div class="border border-secondary rounded d-inline-block" style="width: 160px; height: 200px; background-color: #f8f9fa;">
                            <img id="preview-img" src="#" alt="Preview Foto" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="hapusFoto()" id="btn-hapus-foto" style="display: none;">Hapus Foto</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="no_cm" class="form-label">Nomor CM</label>
                        <input type="text" class="form-control" name="no_cm" value="{{ $no_cm }}" readonly>

                    </div>
                </div>

                <!-- Field yang required -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="no_ktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                        <input type="number" name="no_ktp" class="form-control" required>
                    </div>
                 <div class="col-md-4">
                    <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_laki" value="Laki-laki" required>
                        <label class="form-check-label" for="jk_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_perempuan" value="Perempuan">
                        <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                    </div>
                </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                        <input type="number" name="no_hp" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_pendaftaran" class="form-label">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pendaftaran" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                    </div>
                </div>
                <!-- Field tambahan -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama" class="form-select select2 w-100" required>
                            <option value="">-- Pilih --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                        <select name="status_pernikahan" class="form-select select2" >
                            <option value="">-- Pilih --</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Cerai">Cerai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <select name="golongan_darah" class="form-select select2">
                            <option value="">-- Pilih --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pendidikan" class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <select name="pekerjaan" class="form-select select2">
                                <option value="">-- Pilih Jenis Pekerjaan --</option>
                                <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                <option value="PNS">PNS</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                <option value="Buruh">Buruh</option>
                                <option value="Pensiunan">Pensiunan</option>
                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>

                    </div>
                   
                     <div class="col-md-4">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                     <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="provinsi" name="provinsi" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="kota" class="form-label">Kota/Kab</label>
                        <input type="kota" name="kota" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="kecamatan" name="kecamatan" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="kelurahan" class="form-label">kelurahan</label>
                       <input type="kelurahan" name="kelurahan" class="form-control">
                    </div>
                </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Catatan Pasien</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan catatan khusus mengenai pasien, jika ada..."></textarea>
                    </div>

                </div>

                <h5 class="mt-4">Data Penanggung Jawab</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control">
                    </div>
                  <div class="col-md-4">
                        <label for="hubungan" class="form-label">Hubungan</label>
                        <select name="hubungan" class="form-select select2">
                            <option value="">-- Pilih Hubungan --</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Anak">Anak</option>
                            <option value="Saudara Kandung">Saudara Kandung</option>
                            <option value="Pasangan">Pasangan</option>
                            <option value="Kakek/Nenek">Kakek/Nenek</option>
                            <option value="Keponakan">Keponakan</option>
                            <option value="Sepupu">Sepupu</option>
                            <option value="Wali Lainnya">Wali Lainnya</option>
                        </select>
                    </div>

                  <div class="col-md-4">
                        <label for="no_hp_wali" class="form-label">No HP Wali</label>
                        <input type="number" name="no_hp_wali" class="form-control" min="0">
                    </div>
                <div class="mb-3">
                    <label for="alamat_wali" class="form-label">Alamat Wali</label>
                    <textarea name="alamat_wali" class="form-control"></textarea>
                </div>

                

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFoto(event) {
    const img = document.getElementById('preview-img');
    const btnHapus = document.getElementById('btn-hapus-foto');
    const file = event.target.files[0];

    if (file) {
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
        btnHapus.style.display = 'inline-block';
    } else {
        img.src = '#';
        img.style.display = 'none';
        btnHapus.style.display = 'none';
    }
}

function hapusFoto() {
    const fileInput = document.getElementById('foto');
    const preview = document.getElementById('preview-img');
    const btnHapus = document.getElementById('btn-hapus-foto');

    preview.src = '#';
    preview.style.display = 'none';
    fileInput.value = '';
    btnHapus.style.display = 'none';
}
</script>
@endsection
