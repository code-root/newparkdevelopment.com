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
            <span class="text-muted fw-light">Gallery</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Gallery</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a class="send-model dt-button create-new btn btn-primary waves-effect waves-light" tabindex="0" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Gallery</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Category</th>
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

<!-- Modal for delete confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد أنك تريد حذف هذا العنصر؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end " id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">New Gallery</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="error-messages"></div>
        
        {{ Form::open(['route' => ['gallery.create'],'id'=>'store-form' , 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        
        <!-- حقل الصورة -->
        {{ Form::label('image', 'Image') }}
        {{ Form::file('image', ['id' => 'image', 'name' => 'image', 'class' => 'form-control']) }}
        
        <!-- حقل الحالة -->
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', ['1' => 'active', '0' => 'not active'], null, ['class' => 'form-control']) }}

        <!-- حقل الفئة -->
        {{ Form::label('category_id', 'Category') }}
        {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

<!-- Modal to edit record -->
<div class="offcanvas offcanvas-end" id="edit-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="editModalLabel">Edit Gallery</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="edit-error-messages"></div>
        
        {{ Form::open(['route' => ['gallery.update', ':id'], 'id' => 'edit-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        
        <!-- حقل الصورة -->
        {{ Form::label('edit_image', 'Image') }}
        {{ Form::file('image', ['id' => 'edit_image', 'name' => 'image', 'class' => 'form-control']) }}
        
        <!-- حقل الحالة -->
        {{ Form::label('edit_status', 'Status') }}
        {{ Form::select('status', ['1' => 'active', '0' => 'not active'], null, ['class' => 'form-control', 'id' => 'edit_status']) }}

        <!-- حقل الفئة -->
        {{ Form::label('edit_category_id', 'Category') }}
        {{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'id' => 'edit_category_id']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="updateForm">Update</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('gallery.data') }}",
            type: 'GET'
        },
        columns: [
            {
                data: 'image',
                render: function(data, type, row) {
                    var imgSrc = '/view-image/App%5CModels%5CGallery?id='+row.id+'&nameVar=image';
                    return '<img src="' + imgSrc + '" class="img-thumbnail" width="50px">';
                }
            },
            { data: 'status' },
            { data: 'category.name_en' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <a href="/dashboard/home-page/pages/edit/${row.page_id}" class="btn btn-warning">Edit Page</a>
                    
                        <a href="#" class="dropdown-item toggle-status" data-id="${data}" data-status="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'تعطيل' : 'تمكين'}
                        </a>
                        <a href="#" class="dropdown-item delete-gallery" data-id="${data}">
                            <i class="fa fa-trash"></i> حذف
                        </a>
                    `;
                }
            }
        ]
    });

    // Edit gallery
    $(document).on('click', '.edit-gallery', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = `{{ route("gallery.edit", ":id") }}`.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#edit_image').val(''); // Reset the image input
                $('#edit_status').val(data.status);
                $('#edit_category_id').val(data.category_id);
                $('#edit-form').attr('action', "{{ route('gallery.update', '') }}/" + id);
                $('#edit-record').modal('show');
            }
        });
    });

    $('#updateForm').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#edit-form')[0]);
        $.ajax({
            url: $('#edit-form').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#edit-record').modal('hide');
                $('.form-control').removeClass('is-invalid');
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'تم التحديث بنجاح.'
                });
                table.ajax.reload();
            },
            error: function(xhr) {
                var errors = JSON.parse(xhr.responseText).errors;
                var errorMessages = '';
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    errorMessages += '<li>' + value + '</li>';
                });
                $('#edit-error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });

    $('#data-x').on('click', '.toggle-status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: "{{ route('gallery.toggleStatus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "model": "Gallery",
                "status": status
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });

    $('#submitForm').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#store-form')[0]);
        $.ajax({
            url: "{{ route('gallery.create') }}",
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
                    errorMessages += '<li>' + value + '</li>';
                });
                $('#error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });

    $(document).on("click", ".delete-gallery", function () {
        var itemId = $(this).data('id');
        $("#deleteModal").modal('show');
        $("#confirmDelete").off('click').on("click", function () {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('gallery.destroy') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': itemId
                },
                success: function(data) {
                    $("#deleteModal").modal('hide');
                    table.ajax.reload();
                    Lobibox.notify('success', {
                        title: 'Success',
                        msg: 'تم الحذف بنجاح.'
                    });
                }
            });
        });
    });
});
</script>
@endsection
@endsection
