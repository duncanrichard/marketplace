@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Dashboard</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label>End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Nama Event</label>
                <div class="input-group">
                    <input type="text" name="event" id="selectedEvent" class="form-control" value="{{ $selectedEvent }}"
                        readonly placeholder="-- Pilih Event --">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#eventSelectModal">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary mt-2">Terapkan</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary mt-2">Reset</a>
            </div>
        </form>
    </div>

    <div class="col-md-4">
        <h5 class="mb-2">Event Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})</h5>
        <ul class="list-group">
            @forelse($todayEvents as $event)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $event->judul }}
                <span class="badge bg-success">{{ $event->pra_members_count }} Pra Member</span>
            </li>
            @empty
            <li class="list-group-item text-muted">Tidak ada event hari ini.</li>
            @endforelse
        </ul>
    </div>
</div>

@if($eventNames->count() > 0)
<hr>
<h5><i class="bi bi-bar-chart-fill me-2"></i>Ringkasan Jumlah Pra Member Berdasarkan Event</h5>
<canvas id="chartEvent" height="100"></canvas>
@else
<div class="alert alert-info">Tidak ada data event untuk ditampilkan.</div>
@endif

@if($visitDates->count() > 0)
<hr>
<h5 class="mt-4">
    <i class="bi bi-graph-up me-2"></i>
    Grafik Kunjungan Marketing –
    <small class="text-muted">
        ({{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} –
        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }})
    </small>
</h5>
<canvas id="chartVisit" height="100"></canvas>
@else
<div class="alert alert-info mt-4">Tidak ada data kunjungan dalam periode ini.</div>
@endif

<!-- Modal Pilih Event -->
<div class="modal fade" id="eventSelectModal" tabindex="-1" aria-labelledby="eventSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="selectEventTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Event</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allEvents as $i => $event)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $event->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary pilih-event-btn"
                                    data-judul="{{ $event->judul }}" data-bs-dismiss="modal">
                                    Pilih
                                </button>
                            </td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Event
        const ctxEvent = document.getElementById('chartEvent');
        if (ctxEvent) {
            new Chart(ctxEvent, {
                type: 'bar',
                data: {
                    labels: @json($eventNames),
                    datasets: [{
                        label: 'Jumlah Pra Member',
                        data: @json($memberCounts),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.raw + ' orang'
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // Chart Visit
        const ctxVisit = document.getElementById('chartVisit');
        if (ctxVisit) {
            new Chart(ctxVisit, {
                type: 'line',
                data: {
                    labels: @json($visitDates),
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: @json($visitCounts),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.raw + ' kunjungan'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // DataTable Event Selector
        $('#selectEventTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                },
                zeroRecords: "Data tidak ditemukan"
            }
        });

        // Pilih event dari modal
        document.querySelectorAll('.pilih-event-btn').forEach(button => {
            button.addEventListener('click', function() {
                const judul = this.getAttribute('data-judul');
                document.getElementById('selectedEvent').value = judul;
            });
        });
    });
</script>
@endsection