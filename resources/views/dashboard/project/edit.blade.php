@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Project</span>
        </h4>

        <div id="alert-container"></div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Project Information</h5>
                    </div>
                    <form id="edit-project-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $project->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ $project->title }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" required>{{ $project->description }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="count">Count</label>
                                    <input type="number" id="count" name="count" class="form-control" value="{{ $project->count }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $project->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="images">Images</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                                    <div class="mt-3">
                                        @foreach($project->images as $image)
                                        <div class="image-preview" style="display: inline-block; position: relative;">
                                            <img src="{{ asset('/storage/app/public/' . $image->path) }}" alt="Project Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $image->id }}" style="position: absolute; top: 0; right: 0;">&times;</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="token" name="token" value="{{ $project->token }}" class="form-control">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script src="{{ asset('assets/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<script>
$(document).ready(function() {
    tinymce.init({
        selector: 'textarea',
        height: 400,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | link image | code',
        branding: false,
        setup: function (editor) {
            editor.on('keyup', function () {
                saveTextData();
            });
        }
    });

    $('#edit-project-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('project.update', $project->id) }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#alert-container').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    response.success +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                $('#alert-container').html(errorHtml);
            }
        });
    });

    $('.delete-image').click(function() {
        var imageId = $(this).data('id');
        var imageElement = $(this).closest('.image-preview');
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'لن تتمكن من استعادة هذه الصورة!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذفها!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('projectImage.delete') }}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': imageId
                    },
                    success: function(response) {
                        imageElement.remove();
                        Swal.fire('تم الحذف!', 'تم حذف الصورة بنجاح.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
@endsection