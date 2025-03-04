@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Blogs</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Blogs</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('blog.create') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light" >
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Blog</span></span>
                                </a>
                            </div>
                        </div>

                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('blog.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'title' },
            { data: 'author' },
            { data: 'created_at' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("blog.edit", ":id") }}`.replace(':id', data);
                    var deleteUrl = `{{ route("blog.destroy", ":id") }}`.replace(':id', data);
                    return `
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a href="${editUrl}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a></li>
                                <li><a href="#" class="dropdown-item delete-blog" data-id="${data}"><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#data-x').on('click', '.delete-blog', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    if (confirm('Are you sure you want to delete this blog?')) {
        $.ajax({
            url: "{{ route('blog.destroy', ':id') }}".replace(':id', id),
            type: "DELETE",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                table.ajax.reload();
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'Blog deleted successfully.'
                });
            },
            error: function(xhr) {
                Lobibox.notify('error', {
                    title: 'Error',
                    msg: 'Failed to delete blog.'
                });
            }
        });
    }
});


});
</script>
@endsection
@endsection
