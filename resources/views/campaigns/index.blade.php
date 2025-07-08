@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30">
                <h2>Campaign List</h2>
            </div>
        </div>
        {{-- Tombol Add Campaign --}}
        <div class="col-md-6 text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                Add Campaign
            </button>
        </div>

    </div>
</div>


<div class="card-style-3 mb-30">
    <div class="card-content">
        <div class="table-wrapper table-responsive">
            <table id="campaigns-table" class="table striped-table display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Campaign Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $index => $campaign)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $campaign->name }}</td>
                        <td class="text-center">{{ $campaign->description }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $campaign->status === 'Active' ? 'success' : 'danger' }}">
                                {{ $campaign->status }}
                            </span>

                        </td>
                        <td class="text-center">
                            <form action="{{ route('campaign-categories.destroy', $campaign->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Campaign -->
<div class="modal fade" id="addCampaignModal" tabindex="-1" aria-labelledby="addCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('campaign-categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCampaignModalLabel">Add New Campaign</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Campaign Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Campaign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Edit Campaign -->
<div class="modal fade" id="editCampaignModal" tabindex="-1" aria-labelledby="editCampaignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editCampaignForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editCampaignModalLabel">Edit Campaign</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Campaign Name</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit-status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit-description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#campaigns-table').DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        searching: false
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#campaigns-table tbody').on('click', 'tr', function() {
        const row = $(this).closest('tr');
        const name = row.find('td:nth-child(2)').text().trim();
        const description = row.find('td:nth-child(3)').text().trim();
        const status = row.find('span.badge').text().trim();
        const id = row.find('form').attr('action').split('/').pop();

        $('#edit-name').val(name);
        $('#edit-description').val(description);
        $('#edit-status').val(status);

        $('#editCampaignForm').attr('action', `/c-panel/campaign-categories/${id}`);

        const modal = new bootstrap.Modal(document.getElementById('editCampaignModal'));
        modal.show();
    });
});
</script>

@endsection