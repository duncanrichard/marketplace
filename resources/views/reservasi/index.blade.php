@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Data Reservasi Pasien') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">

                <div class="table-wrapper table-responsive">
                    <table class="table striped-table nowrap" id="reservasi" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><h6>No</h6></th>
                                <th><h6>Nama</h6></th>
                                <th><h6>No CM</h6></th>
                                <th><h6>Total Reservasi</h6></th>
                                <th><h6>Aksi</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($grouped as $pasien_id => $items)
                                @php $pasien = $items[0]->pasien ?? null; @endphp
                                @if($pasien)
                                    <tr>
                                        <td><p>{{ $no++ }}</p></td>
                                        <td><p>{{ $pasien->nama }}</p></td>
                                        <td><p>{{ $pasien->no_cm }}</p></td>
                                        <td><p>{{ count($items) }}</p></td>
                                        <td>
                                            <a href="{{ route('reservasi.detail', $pasien_id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
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
 <script src="{{ asset('Modal/reservasi.js') }}"></script>
@endsection

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection
