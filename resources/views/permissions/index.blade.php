@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Manajemen Hak Akses</h2>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card-style-3 mb-30">
    <div class="card-content">
        <div class="table-wrapper table-responsive">
            <form action="{{ route('permissions.update') }}" method="POST">
                @csrf
                <table class="table table-bordered" id="permissionsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Aksi</th>
                            @foreach($roles as $role)
                            <th class="text-center">{{ ucfirst($role) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td> <!-- Kolom No -->
                            <td>{{ readableMenuName($permission->menu) }}</td>
                            <td>{{ ucfirst($permission->action) }}</td>
                            @foreach($roles as $role)
                            <td class="text-center">
                                <input type="checkbox" name="permissions[{{ $role }}][{{ $permission->id }}]"
                                    {{ $rolePermissions->where('role', $role)->where('permission_id', $permission->id)->count() ? 'checked' : '' }}>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#permissionsTable').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        columnDefs: [{
                orderable: false,
                targets: "_all"
            } // semua kolom non-sortable, bisa diubah sesuai kebutuhan
        ]
    });
});
</script>
@endsection