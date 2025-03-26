@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add New Blog</span>
        </h4>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Blog Information</h5>
                    </div>
                    <div id="error-messages" class="alert alert-danger d-none" role="alert">
                        <ul id="error-list"></ul>
                    </div>
                    <form id="add-blog-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="5" ></textarea>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="author">Author</label>
                                    <input type="text" id="author" name="author" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="image">Main Image</label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="images">Additional Images</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add New Blog</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer-script')
<script>
            tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    $('#add-blog-form').on('submit', function(e) {
        e.preventDefault();
        let submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Submitting...');
        $('#error-messages').addClass('d-none');
        $('#error-list').empty();

        $.ajax({
            url: "{{ route('blog.create') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = "{{ route('blog.index') }}";
            },
            error: function(xhr) {
                submitButton.prop('disabled', false).text('Add New Blog');
                $('#error-messages').removeClass('d-none');
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#error-list').append('<li>' + value[0] + '</li>');
                });
            }
        });
    });
</script>
@endsection
