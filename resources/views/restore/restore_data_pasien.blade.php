@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Restore Data Pasien</h2>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        @if($pasien->count())
        <table class="table striped-table nowrap" id="data_pasien" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No KTP</th>
                    <th>No CM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasien as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_ktp }}</td>
                    <td>{{ $item->no_cm }}</td>
                    <td>
                        <form action="{{ route('data-pasien.restore', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin merestore data ini?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-undo-alt"></i> Restore
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info">
            Tidak ada data pasien yang dihapus.
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('Modal/data_pasien.js') }}"></script>
    @endsection

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection
