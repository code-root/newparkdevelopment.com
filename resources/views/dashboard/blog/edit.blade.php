@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Blog</span>
        </h4>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div id="error-messages" class="alert alert-danger d-none" role="alert">
            <ul id="error-list"></ul>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Blog Information</h5>
                    </div>
                    <form id="edit-blog-form" method="post" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $blog->name }}" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ $blog->title }}" required>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" {{ $blog->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $blog->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="image">Main Image</label>
                                    <input type="file" id="image" name="image" class="form-control">
                                    @if($blog->image)
                                    <img src="https://newparkdevelopment.com/backend/storage/app/public/{{  $blog->image }}" alt="Blog Image" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="images">Additional Images</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                                    <div class="mt-2">
                                        @foreach($blog->images as $image)
                                        <div class="image-preview d-inline-block position-relative me-2">
                                            <img src="https://newparkdevelopment.com/backend/storage/app/public/{{ $image->path  }}" alt="Blog Image" class="img-thumbnail" width="100">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image" data-id="{{ $image->id }}">X</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="5">{{ $blog->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="update-button">Update Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer-script')
<script>
$(document).ready(function() {
    tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    $('#edit-blog-form').on('submit', function(e) {
        e.preventDefault();

        let submitButton = $('#update-button');
        submitButton.prop('disabled', true).text('Updating...');

        $('#error-messages').addClass('d-none');
        $('#error-list').empty();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = "{{ route('blog.index') }}";
            },
            error: function(xhr) {
                submitButton.prop('disabled', false).text('Update Blog');

                $('#error-messages').removeClass('d-none');
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#error-list').append('<li>' + value[0] + '</li>');
                });
            }
        });
    });

    // حذف الصورة
    $('.delete-image').click(function() {
        var imageId = $(this).data('id');
        var imageElement = $(this).closest('.image-preview');

        $.ajax({
            url: "{{ route('image.delete') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': imageId
            },
            success: function(response) {
                imageElement.remove();
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
});
</script>
@endsection
@endsection
