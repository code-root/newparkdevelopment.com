@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">DataTables</span> Success Partners</h4>
            <div class="card">
                <div class="card-header">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">All Success Partners</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#successPartnerModal">
                                    <i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped nowrap" id="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($successPartners as $partner)
                                    <tr>
                                        <td>{{ $partner->id }}</td>
                                        <td>{{ $partner->name }}</td>
                                        <td><img width="180px" src="{{ route('api.image.partners') }}?id={{  $partner->id }}" alt="{{ $partner->name }}" width="100"></td>
                                        <td>
                                            <div class="d-inline-block">
                                                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end m-0">
                                                    <a href="javascript:;" class="dropdown-item btn-edit" data-id="{{ $partner->id }}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <button type="button" class="dropdown-item text-danger delete-record" data-id="{{ $partner->id }}">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Success Partner Modal -->
<div class="modal fade" id="successPartnerModal" tabindex="-1" aria-labelledby="successPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="successPartnerForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="successPartnerModalLabel">Add New Success Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="successPartnerId" name="successPartnerId">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="logos" class="form-label">Logos</label>
                        <input type="file" class="form-control" id="logos" name="logos[]" accept="image/*" multiple>
                        <div class="invalid-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('#table').DataTable({
        responsive: true,
        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ]
    });

    $('#successPartnerForm').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = $('#successPartnerId').val();
    let url = id ? `{{ route('success_partners.update', '') }}/${id}` : `{{ route('success_partners.store') }}`;
    let method = id ? 'PUT' : 'POST';

    $.ajax({
        type: method,
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': csrfToken},
        success: function(response) {
            if (response.success) {
                $('#successPartnerModal').modal('hide');
                location.reload(); // Reload the table data
            } else {
                Swal.fire(
                    'Error!',
                    'There was an error saving the record.',
                    'error'
                );
            }
        },
        error: function(response) {
            // Handle error
        }
    });
});

    // Open modal for editing
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: `{{ route('success_partners.edit', '') }}/${id}`,
            success: function(response) {
                if (response.success) {
                    let partner = response.data;

                    $('#successPartnerId').val(partner.id);
                    $('#name').val(partner.name);

                    // Clear previous file selection in the input
                    $('#logo').val('');
                    $('#logo').next('.invalid-feedback').text('');

                    $('#successPartnerModal').modal('show');
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error fetching the record.',
                        'error'
                    );
                }
            },
            error: function(response) {
                // Handle error
            }
        });
    });

    // Handle delete action
    $('.delete-record').on('click', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `{{ route('success_partners.destroy', '') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the record.',
                                'error'
                            );
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the record.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endsection
