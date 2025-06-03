@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Edit Data Pasien</h2>
            </div>
        </div>
        <div class="col-md-6 text-end mb-3">
            <a href="{{ route('data-pasien.index') }}" class="btn btn-secondary">Kembali ke Daftar Pasien</a>
        </div>
    </div>
</div>

<div class="card-style-3 mb-30">
   

        <form action="{{ route('data-pasien.update', $pasien->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Foto --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="foto" class="form-label">Upload Foto Pasien</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">
                </div>
                <div class="col-md-6 text-center">
                    <label class="form-label d-block">Preview Foto</label>
                    <div class="border border-secondary rounded d-inline-block" style="width: 160px; height: 200px; background-color: #f8f9fa;">
                        <img id="preview-img" src="{{ asset($pasien->foto) }}" alt="Preview Foto" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>

            {{-- Baris 1 --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $pasien->nama) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">No KTP <span class="text-danger">*</span></label>
                    <input type="number" name="no_ktp" class="form-control" value="{{ old('no_ktp', $pasien->no_ktp) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select select2" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" required>
                </div>
            </div>

            {{-- Baris 3 --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                    <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp', $pasien->no_hp) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pendaftaran" class="form-control" value="{{ old('tanggal_pendaftaran', $pasien->tanggal_pendaftaran) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $pasien->email) }}">
                </div>
            </div>

            {{-- Baris 4 --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Agama</label>
                    <select name="agama" class="form-select select2">
                        <option value="">-- Pilih --</option>
                        @foreach (['Islam','Kristen','Katolik','Hindu','Buddha','Lainnya'] as $agama)
                            <option value="{{ $agama }}" {{ old('agama', $pasien->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Pernikahan</label>
                    <select name="status_pernikahan" class="form-select select2">
                        <option value="">-- Pilih --</option>
                        @foreach (['Belum Menikah','Menikah','Cerai'] as $status)
                            <option value="{{ $status }}" {{ old('status_pernikahan', $pasien->status_pernikahan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select select2">
                        <option value="">-- Pilih --</option>
                        @foreach (['A','B','AB','O'] as $gol)
                            <option value="{{ $gol }}" {{ old('golongan_darah', $pasien->golongan_darah) == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $pasien->pendidikan) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $pasien->keterangan) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $pasien->provinsi) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ old('kota', $pasien->kota) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $pasien->kecamatan) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kelurahan</label>
                    <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $pasien->kelurahan) }}">
                </div>
               <div class="mb-3">
                    <label for="keterangan" class="form-label">Catatan Pasien</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan catatan khusus mengenai pasien, jika ada...">{{ old('keterangan', $pasien->keterangan) }}</textarea>
                </div>
<div class="mb-3">
    <label class="form-label">Catatan Khusus</label><br>
<div class="form-check form-check-inline">
    <input type="hidden" name="telat" value="0"> {{-- default jika unchecked --}}
    <input class="form-check-input" type="checkbox" name="telat" id="telat" value="1" {{ old('telat', $pasien->telat) ? 'checked' : '' }}>
    <label class="form-check-label text-warning" for="telat">Telat</label>
</div>
<div class="form-check form-check-inline">
    <input type="hidden" name="tidak_dilayani" value="0"> {{-- default jika unchecked --}}
    <input class="form-check-input" type="checkbox" name="tidak_dilayani" id="tidak_dilayani" value="1" {{ old('tidak_dilayani', $pasien->tidak_dilayani) ? 'checked' : '' }}>
    <label class="form-check-label text-danger" for="tidak_dilayani">Dokter Tidak Mau Melayani</label>
</div>

</div>

            </div>

            <h5 class="mt-4">Data Penanggung Jawab</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Wali</label>
                    <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $pasien->nama_wali) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hubungan</label>
                    <select name="hubungan" class="form-select select2">
                        <option value="">-- Pilih Hubungan --</option>
                        @foreach (['Orang Tua','Anak','Saudara Kandung','Pasangan','Kakek/Nenek','Keponakan','Sepupu','Wali Lainnya'] as $hub)
                            <option value="{{ $hub }}" {{ old('hubungan', $pasien->hubungan) == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">No HP Wali</label>
                    <input type="number" name="no_hp_wali" class="form-control" value="{{ old('no_hp_wali', $pasien->no_hp_wali) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Wali</label>
                <textarea name="alamat_wali" class="form-control">{{ old('alamat_wali', $pasien->alamat_wali) }}</textarea>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update Data</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewFoto(event) {
        const img = document.getElementById('preview-img');
        const file = event.target.files[0];
        if (file) {
            img.src = URL.createObjectURL(file);
        }
    }

    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Pilih --',
            allowClear: true
        });
    });
</script>
@endpush

@endsection
