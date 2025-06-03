@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-4 mb-4">
    <div class="bg-light p-4 rounded shadow-sm d-flex align-items-center">
        <i class="bi bi-calendar-check me-3 fs-2 text-primary"></i>
        <div>
            <h4 class="mb-1 fw-bold text-dark">Detail Reservasi Pasien</h4>
            <p class="mb-0 text-muted">
                <strong>{{ $pasien->nama }}</strong> &nbsp;|&nbsp; No CM: <strong>{{ $pasien->no_cm }}</strong>
            </p>
        </div>
    </div>
</div>

<div class="card-style-3 mb-30">
    <div class="table-wrapper table-responsive">
        <table class="table striped-table" id="reservasi" style="width: 100%;">
            <thead class="text-center">
                <tr class="text-center">
                <th class="text-nowrap">No</th>
                <th class="text-nowrap">Tanggal Reservasi</th>
                <th class="text-nowrap">Jam Reservasi</th>
                <th class="text-nowrap">Jam Kedatangan</th>
                <th class="text-nowrap">Selisih Waktu</th>
                <th class="text-nowrap">Status Reservasi</th>
                <th class="text-nowrap">Catatan</th>
                <th class="text-nowrap">Konfirmasi</th>
            </tr>

            </thead>
            <tbody>
                @foreach($reservasis as $r)
                    <tr >
                        <td>{{ $loop->iteration }}</td>
                      <td>{{ \Carbon\Carbon::parse($r->tanggal_reservasi)->translatedFormat('d F Y') }}</td>
                        <td>{{ $r->jam_reservasi }}</td>
                        <td>{{ $r->jam_kedatangan ?? '-' }}</td>
                       <td class="text-center">
                            @if ($r->jam_kedatangan)
                                @php
                                    $jamKedatangan = \Carbon\Carbon::createFromFormat('H:i:s', $r->jam_kedatangan);
                                    $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $r->jam_reservasi);
                                    $diff = $jamKedatangan->diff($jamReservasi);
                                    $tanda = $jamKedatangan->greaterThan($jamReservasi) ? '+' : '-';
                                @endphp
                                <span class="{{ $tanda == '+' ? 'text-danger' : 'text-success' }}">
                                    {{ $tanda }}{{ $diff->h > 0 ? $diff->h . ' jam ' : '' }}{{ $diff->i }} menit
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($r->status_reservasi == 'Booked')
                                <span class="badge bg-success">{{ $r->status_reservasi }}</span>
                            @elseif ($r->status_reservasi == 'Pending')
                                <span class="badge bg-warning text-dark">{{ $r->status_reservasi }}</span>
                            @elseif ($r->status_reservasi == 'Batal')
                                <span class="badge bg-danger">{{ $r->status_reservasi }}</span>
                            @elseif ($r->status_reservasi == 'Dikonfirmasi')
                                <span class="badge bg-primary">{{ $r->status_reservasi }}</span>
                            @elseif ($r->status_reservasi == 'Reschedule')
                                <span class="badge bg-info text-dark">{{ $r->status_reservasi }}</span>
                            @else
                                {{ $r->status_reservasi }}
                            @endif
                        </td>
                        <td>{{ $r->catatan ?? '-' }}</td>
                       <td class="text-center">
    @if ($r->status_reservasi == 'Batal')
        <span class="badge bg-danger">Batal</span>
    @elseif ($r->jam_kedatangan)
        <span class="badge bg-success">Terkonfirmasi</span>
    @else
        <form id="form-konfirmasi-{{ $r->id }}" action="{{ route('reservasi.konfirmasiKedatangan', $r->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="jam_kedatangan" id="jam-kedatangan-{{ $r->id }}">
           @php
    $tanggalFormatted = \Carbon\Carbon::parse($r->tanggal_reservasi)->format('Y-m-d');
@endphp
<button type="button" class="btn btn-sm btn-warning"
    onclick="showRescheduleModal({{ $r->id }}, '{{ $tanggalFormatted }}')">Konfirmasi</button>

        </form>
    @endif
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('reservasi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
<!-- Modal Konfirmasi / Reschedule / Batal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="rescheduleModalLabel">Kelola Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <form id="formReschedule" method="POST" action="{{ route('reservasi.reschedule') }}">
        @csrf
        <input type="hidden" name="id_reservasi" id="reschedule_id">

        <div class="modal-body">
          <p class="text-danger">Pilih aksi yang ingin dilakukan untuk reservasi ini:</p>

          <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="aksi" id="aksi_reschedule" value="reschedule"  onchange="toggleRescheduleForm(true)">
            <label class="form-check-label" for="aksi_reschedule">
              Reschedule Jadwal
            </label>
          </div>

          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="aksi" id="aksi_batal" value="batal" onchange="toggleRescheduleForm(false)">
            <label class="form-check-label" for="aksi_batal">
              Batalkan Reservasi
            </label>
          </div>

          <!-- Form reschedule -->
          <div id="reschedule_fields" class="mt-3">
            <div class="mb-2">
              <label for="tanggal_reschedule" class="form-label">Tanggal Baru</label>
              <input type="date" name="tanggal_reschedule" id="tanggal_reschedule" class="form-control" min="{{ date('Y-m-d') }}">
            </div>
            <div>
              <label for="jam_reschedule" class="form-label">Jam Baru</label>
              <input type="time" name="jam_reschedule" id="jam_reschedule" class="form-control">
            </div>
          </div>

          <!-- Hidden input untuk konfirmasi -->
          <input type="hidden" id="konfirmasi_id" name="konfirmasi_id">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
       <button type="button" class="btn btn-success"
    onclick="submitKonfirmasiLangsung()">
    Konfirmasi Kedatangan
</button>



          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
    // Submit konfirmasi kedatangan
  function submitKonfirmasiLangsung() {
    const id = document.getElementById('reschedule_id').value;

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'jam_kedatangan';
    hiddenInput.value = new Date().toLocaleTimeString('en-GB', { hour12: false });

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('c-panel/reservasi/konfirmasi') }}/${id}`;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'PUT';

    form.appendChild(hiddenInput);
    form.appendChild(csrf);
    form.appendChild(method);

    document.body.appendChild(form);
    form.submit();
}

    // Tampilkan modal dan set ID
   function showRescheduleModal(reservasiId, tanggalReservasi) {
    document.getElementById('reschedule_id').value = reservasiId;

    const today = new Date().toISOString().split('T')[0]; // Format yyyy-mm-dd
    const btnKonfirmasi = document.querySelector('#rescheduleModal .btn-success');

    // Tampilkan tombol hanya jika tanggal reservasi = hari ini
    if (tanggalReservasi === today) {
        btnKonfirmasi.style.display = 'inline-block';
    } else {
        btnKonfirmasi.style.display = 'none';
    }

    toggleRescheduleForm(true);
    const modal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
    modal.show();
}


    // Toggle antara opsi Reschedule dan Batal
    function toggleRescheduleForm(show) {
        const rescheduleFields = document.getElementById('reschedule_fields');
        const tanggal = document.getElementById('tanggal_reschedule');
        const jam = document.getElementById('jam_reschedule');

        if (show) {
            rescheduleFields.style.display = 'block';
            tanggal.required = true;
            jam.required = true;
        } else {
            rescheduleFields.style.display = 'none';
            tanggal.required = false;
            jam.required = false;
        }
    }
</script>


@section('scripts')
    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('Modal/reservasi.js') }}"></script>
@endsection

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection
