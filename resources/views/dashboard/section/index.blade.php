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
            <span class="text-muted fw-light">Sections</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table Sections</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a class="send-model dt-button create-new btn btn-primary waves-effect waves-light" tabindex="0" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Section</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Name (Arabic)</th>
                                <th>Name (English)</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Pages</th> <!-- عمود الصفحات -->
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

<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end " id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">New Section</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="error-messages"></div>

        {{ Form::open(['route' => ['section.create'],'id'=>'store-form' , 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

        <!-- حقل الاسم باللغة العربية -->
        {{ Form::label('name_ar', 'Name AR') }}
        {{ Form::text('name_ar', null, ['class' => 'form-control']) }}

        <!-- حقل الاسم باللغة الإنجليزية -->
        {{ Form::label('name_en', 'Name EN') }}
        {{ Form::text('name_en', null, ['class' => 'form-control']) }}

        <!-- حقل السلاج -->
        {{ Form::label('slug', 'Slug') }}
        {{ Form::text('slug', null, ['class' => 'form-control']) }}

        <!-- حقل الحالة -->
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', ['1' => 'active', '0' => 'not active'], null, ['class' => 'form-control']) }}

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
        <h5 class="offcanvas-title" id="editModalLabel">Edit Section</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="edit-error-messages"></div>

        {{ Form::open(['route' => ['section.update', ':id'], 'id' => 'edit-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

        <!-- حقل الاسم باللغة العربية -->
        {{ Form::label('edit_name_ar', 'Name AR') }}
        {{ Form::text('name_ar', null, ['class' => 'form-control', 'id' => 'edit_name_ar']) }}

        <!-- حقل الاسم باللغة الإنجليزية -->
        {{ Form::label('edit_name_en', 'Name EN') }}
        {{ Form::text('name_en', null, ['class' => 'form-control', 'id' => 'edit_name_en']) }}

        <!-- حقل السلاج -->
        {{ Form::label('edit_slug', 'Slug') }}
        {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'edit_slug']) }}

        <!-- حقل الحالة -->
        {{ Form::label('edit_status', 'Status') }}
        {{ Form::select('status', ['1' => 'active', '0' => 'not active'], null, ['class' => 'form-control', 'id' => 'edit_status']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="updateForm">Update</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

<!-- Modal to add new page -->
<div class="offcanvas offcanvas-end" id="add-new-page">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="addPageModalLabel">Add New Page</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <div id="page-error-messages"></div>

        {{ Form::open(['route' => ['page.save', ':section_id'], 'id' => 'page-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

        <!-- حقل الاسم باللغة العربية -->
        {{ Form::label('page_name_ar', 'Name AR') }}
        {{ Form::text('name_ar', null, ['class' => 'form-control']) }}

        <!-- حقل الاسم باللغة الإنجليزية -->
        {{ Form::label('page_name_en', 'Name EN') }}
        {{ Form::text('name_en', null, ['class' => 'form-control']) }}

        <!-- حقل الوصف باللغة العربية -->
        {{ Form::label('page_description_ar', 'Description AR') }}
        {{ Form::textarea('description_ar', null, ['class' => 'form-control']) }}

        <!-- حقل الوصف باللغة الإنجليزية -->
        {{ Form::label('page_description_en', 'Description EN') }}
        {{ Form::textarea('description_en', null, ['class' => 'form-control']) }}

        <br>
        <br>
        <!-- زر الإرسال -->
        <button type="button" class="btn btn-primary" id="submitPageForm">Submit</button>
        <!-- حقل CSRF -->
        @csrf
        {{ Form::close() }}
    </div>
</div>

@section('footer')

<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('section.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name_ar' },
            { data: 'name_en' },
            { data: 'slug' },
            { data: 'status' },
            {
                data: 'pages', // عرض الصفحات المرتبطة
                render: function(data, type, row) {
                    if (Array.isArray(data) && data.length > 0) {
                        var pagesList = data.map(page => {
                            var editUrl = `{{ route('pages.edit', ':id') }}`.replace(':id', page.id);
                            var deleteUrl = `{{ route('pages.destroy', ':id') }}`.replace(':id', page.id);
                            return `
                                <li>
                                    ${page.name_en} (${page.name_ar})
                                    <a href="${editUrl}" class="btn btn-sm btn-warning">تعديل</a>
                                    <button class="btn btn-sm btn-danger delete-page" data-id="${page.id}" data-url="${deleteUrl}">حذف</button>
                                </li>
                            `;
                        }).join('');
                        return `<ul>${pagesList}</ul>`;
                    } else {
                        return '<ul><li>No pages available</li></ul>';
                    }
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("section.edit", ":id") }}`.replace(':id', data);
                    var addPageUrl = `{{ route("page.create", ":section_id") }}`.replace(':section_id', data);
                    return `
                        <a href="#" class="dropdown-item edit-section" data-id="${data}" data-url="${editUrl}"  data-bs-toggle="offcanvas" data-bs-target="#edit-record">
                            <i class="fa fa-pencil"></i> تعديل
                        </a>
                        <a href="#" class="dropdown-item add-page" data-id="${data}" data-bs-toggle="offcanvas" data-bs-target="#add-new-page">
                            <i class="fa fa-plus"></i> إضافة صفحة جديدة
                        </a>
                        <a href="#" class="dropdown-item toggle-status" data-id="${data}" data-status="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'تعطيل' : 'تمكين'}
                        </a>
                    `;
                }
            }
        ]
    });

    // عند الضغط على زر التعديل
    $(document).on('click', '.edit-section', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).data('url');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // تأكد من أن البيانات تأتي بشكل صحيح
                if (response.data) {
                    $('#edit_name_ar').val(response.data.name_ar);
                    $('#edit_name_en').val(response.data.name_en);
                    $('#edit_slug').val(response.data.slug);
                    $('#edit_status').val(response.data.status);
                    $('#edit-form').attr('action', "{{ route('section.update', '') }}/" + id);
                    $('#edit-record').modal('show');
                } else {
                    console.error('Invalid response structure:', response);
                }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr);
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
            url: "{{ route('section.toggleStatus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "model": "Section",
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
            url: "{{ route('section.create') }}",
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

    $(document).on("click", ".delete-section", function () {
        var itemId = $(this).data('id');
        $("#deleteModal").modal('show');
        $("#confirmDelete").on("click", function () {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('section.destroy') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': itemId,
                    'model': "Section"
                },
                success: function(data) {
                    $("#deleteModal").modal('hide');
                    table.ajax.reload();
                }
            });
        });
    });

    // عند الضغط على زر إضافة صفحة
    $(document).on('click', '.add-page', function(e) {
        e.preventDefault();
        var sectionId = $(this).data('id');
        $('#page-form').attr('action', "{{ route('page.save', ':section_id') }}".replace(':section_id', sectionId));
        $('#add-new-page').modal('show');
    });

    $('#submitPageForm').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#page-form')[0]);
        $.ajax({
            url: $('#page-form').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add-new-page').modal('hide');
                $('.form-control').removeClass('is-invalid');
                Lobibox.notify('success', {
                    title: 'Success',
                    msg: 'تمت الإضافة بنجاح.'
                });
                $('#page-form')[0].reset();
                table.ajax.reload();
            },
            error: function(xhr) {
                var errors = JSON.parse(xhr.responseText).errors;
                var errorMessages = '';
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    errorMessages += '<li>' + value + '</li>';
                });
                $('#page-error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });

    $(document).on('click', '.delete-page', function(e) {
        e.preventDefault();
        var pageId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        if (confirm('هل أنت متأكد أنك تريد حذف هذه الصفحة؟')) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}', // تأكد من تضمين CSRF token
                    'id': pageId
                },
                success: function(response) {
                    Lobibox.notify('success', {
                        title: 'Success',
                        msg: 'تم الحذف بنجاح.'
                    });
                    table.ajax.reload(); // إعادة تحميل الجدول لتحديث البيانات
                },
                error: function(xhr) {
                    Lobibox.notify('error', {
                        title: 'Error',
                        msg: 'حدث خطأ أثناء الحذف.'
                    });
                }
            });
        }
    });
});
</script>
@endsection
@endsection
