@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add New Project</span>
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
            <div class="col-12 col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Project Information</h5>
                    </div>
                    <div id="error-messages" class="alert alert-danger d-none" role="alert">
                        <ul id="error-list"></ul>
                    </div>
                    <form id="add-project-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" ></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="count">Count</label>
                                    <input type="number" id="count" name="count" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="images">Images</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add New Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
tinymce.init({
    selector: 'textarea',
    height: 400,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | link image | code',
    branding: false
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#add-project-form').on('submit', function(e) {
    e.preventDefault();
    $('#error-messages').addClass('d-none');
    $('#error-list').empty();

    tinymce.triggerSave();

    $.ajax({
        url: "{{ route('project.create') }}",
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(response) {
            window.location.href = "{{ route('project.index') }}";
        },
        error: function(xhr) {
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
@endsection
