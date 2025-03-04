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
            <span class="text-muted fw-light">Categories</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Categories</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('category.create.page') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light" >
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Category</span></span>
                                </a>
                            </div>
                        </div>

                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>title</th>
                                <th>Status</th>
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
            url: "{{ route('category.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name' },
            { data: 'title' },
            { data: 'status' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("category.edit", ":id") }}`.replace(':id', data);
                    return `
                        <a href="${editUrl}">
                            <i class="fa fa-pencil"></i> edit
                        </a>
                        <a href="#" class="dropdown-item toggle-Update" data-id="${data}" data-Update="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'Disable' : 'Enable'}
                        </a>
                    `;
                }
            }
        ]
    });



    $('#data-x').on('click', '.toggle-Update', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: "{{ route('category.toggleStatus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "model": "Category",
                "status": status
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });

    $('#submitForm').click(function(e) {
        e.preventDefault();
        // الحصول على محتوى TinyMCE
        var descriptionContent = tinymce.get('description').getContent();
        var formData = new FormData($('#store-form')[0]);
        formData.append('description', descriptionContent); // إضافة المحتوى إلى formData

        $.ajax({
            url: "{{ route('category.create') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add-new-record').modal('hide');
                $('.form-control').removeClass('is-invalid');
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'تمت الإضافة بنجاح.'
                });
                $('#store-form')[0].reset();
                table.ajax.reload();
            },
            error: function(xhr) {
                var errors = JSON.parse(xhr.responseText).errors;
                var errorMessages = '';
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    errorMessages += '<li>' + value.join(', ') + '</li>';
                });
                $('#error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });

    $(document).on("click", ".delete-category", function () {
        var itemId = $(this).data('id');
        $("#deleteModal").modal('show');
        $("#confirmDelete").on("click", function () {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('category.destroy') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': itemId,
                    'model': "Category"
                },
                success: function(data) {
                    $("#deleteModal").modal('hide');
                    table.ajax.reload();
                }
            });
        });
    });
});
</script>
@endsection
@endsection
