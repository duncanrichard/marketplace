@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Data Pasien') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end mb-3">
                <a href="{{ route('data-pasien.create') }}" class="btn btn-primary">
                    Tambah Pasien
                </a>
            </div>
        </div>
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">

                <div class="alert-box primary-alert">
                    <div class="alert">
                        <p class="text-medium">
                        Data seluruh pasien yang telah terdaftar.
                        </p>
                    </div>
                </div>

                <div class="table-wrapper table-responsive">
                    <table class="table striped-table nowrap" id="data_pasien" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><h6>No</h6></th>
                                <th><h6>Reservasi</h6></th>
                                <th><h6>Nama</h6></th>
                                <th><h6>No KTP</h6></th>
                                <th><h6>No CM</h6></th>
                                <th><h6>Foto</h6></th>
                                <th><h6>Action</h6></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasien as $item)
                                <tr>
                                    <td><p>{{ $loop->iteration }}</p></td>
                               <td>
                                    @php
                                        // Ambil semua reservasi yang butuh konfirmasi (Booked/Reschedule dan belum datang)
                                        $belumDikonfirmasi = $item->reservasis->filter(function ($r) {
                                            return in_array($r->status_reservasi, ['Booked', 'Reschedule']) && !$r->jam_kedatangan;
                                        });

                                        // Ambil yang paling akhir dari yang belum dikonfirmasi
                                        $latest = $belumDikonfirmasi->sortByDesc(function ($r) {
                                            return $r->tanggal_reservasi . ' ' . $r->jam_reservasi;
                                        })->first();
                                    @endphp

                                    @if ($latest)
                                        <button class="btn btn-sm btn-secondary" title="Reservasi Sudah Ada"
                                            onclick="alert('Pasien {{ $item->nama }} sudah memiliki reservasi dengan status {{ $latest->status_reservasi }} pada tanggal {{ \Carbon\Carbon::parse($latest->tanggal_reservasi)->format('d-m-Y') }} jam {{ $latest->jam_reservasi }} dan belum dikonfirmasi.')">
                                            <i class="fas fa-calendar-check"></i>
                                        </button>
                                    @else
                                        <a href="#" 
                                            class="btn btn-sm btn-success btn-reservasi" 
                                            title="Reservasi"
                                            data-pasien-id="{{ $item->id }}"
                                            data-telat="{{ $item->telat }}"
                                            data-tidak-dilayani="{{ $item->tidak_dilayani }}"
                                        >
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    @endif
                                </td>

                                    <td><p>{{ $item->nama }}</p></td>
                                    <td><p>{{ $item->no_ktp }}</p></td>
                                    <td><p>{{ $item->no_cm }}</p></td>
                                    <td>
                                        @if($item->foto)
                                            <a href="{{ asset($item->foto) }}" target="_blank">
                                                <img src="{{ asset($item->foto) }}" alt="Foto" style="width: 60px; height: 75px; object-fit: cover; cursor: pointer;" title="Klik untuk melihat lebih besar">
                                            </a>
                                        @else
                                            <span class="text-muted">Belum ada foto</span>
                                        @endif
                                    </td>

                                   <td class="text-center">
                                        <a href="{{ route('data-pasien.show', $item->id) }}" class="btn btn-sm btn-info me-1" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('data-pasien.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('data-pasien.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi -->
<div class="modal fade" id="modalKonfirmasiReservasi" tabindex="-1" aria-labelledby="modalKonfirmasiReservasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-warning">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="modalKonfirmasiReservasiLabel">Peringatan</h5>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled" id="pesanPeringatan"></ul>
        <p>Apakah Anda yakin ingin melanjutkan reservasi untuk pasien ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="batalReservasi">Batal</button>
        <a href="#" id="lanjutReservasi" class="btn btn-primary">Lanjutkan</a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('Modal/data_pasien.js') }}"></script>
    <script>
$(document).ready(function () {
    $('.btn-reservasi').on('click', function (e) {
        e.preventDefault();

        const pasienId = $(this).data('pasien-id');
        const telat = parseInt($(this).data('telat'));
        const tidakDilayani = parseInt($(this).data('tidak-dilayani'));

        let showModal = false;
        let pesan = [];

        if (tidakDilayani === 1) {
            pesan.push('<li>❌ <strong>Dokter tidak ingin melakukan tindakan kepada pasien ini.</strong></li>');
            showModal = true;
        }

        if (telat === 1) {
            pesan.push('<li>⚠️ <strong>Pasien ini sering datang terlambat.</strong></li>');
            showModal = true;
        }

        if (showModal) {
            $('#pesanPeringatan').html(pesan.join(''));
           $('#lanjutReservasi').attr('href', "{{ route('reservasi.create') }}?pasien_id=" + pasienId);

            $('#modalKonfirmasiReservasi').modal('show');
        } else {
            // Langsung redirect jika tidak ada flag
            window.location.href = "{{ route('reservasi.create') }}?pasien_id=" + pasienId;

        }
    });

    $('#batalReservasi').on('click', function () {
        $('#modalKonfirmasiReservasi').modal('hide');
    });
});
</script>

@endsection

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection
