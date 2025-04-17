@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<script src="https://cdn.tiny.cloud/1/no-origin/tinymce/7.3.0-86/tinymce.min.js" referrerpolicy="origin"></script>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add </span><span>Page</span></h4>

        <div class="app-ecommerce">
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

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Create New Page</div>
                            <div class="card-body">
                                <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                                    @csrf

                                    <!-- Basic Information -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">Basic Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Page Type *</label>
                                                <select name="type" class="form-select" required>
                                                    <option value="regular">Regular Page</option>
                                                    <option value="section">Section</option>
                                                    <option value="article">Article</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Page Name *</label>
                                                <input type="text" name="name" id="name" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">URL Slug *</label>
                                                <div class="input-group">
                                                    <input type="text" name="slug" id="slug" class="form-control" required>
                                                    <button class="btn btn-outline-secondary" type="button" id="generate-slug">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted">Unique identifier for the page URL</small>
                                                <div id="slug-error" class="text-danger small"></div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Page Content</label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEO Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">SEO Settings</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Meta Title</label>
                                                <input type="text" name="meta_title" class="form-control" placeholder="Meta Title">
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="form-label">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" rows="3" placeholder="Meta Description"></textarea>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="form-label">Page Images</label>
                                                <input type="file" name="images[]" class="form-control" multiple>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">Add Page</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        $('#generate-slug').click(function () {
            const name = $('#name').val();
            if (name) {
                $.post("{{ route('pages.check-slug') }}", {
                    name: name
                }, function (data) {
                    $('#slug').val(data.slug);
                    $('#slug-error').hide();
                });
            }
        });

        $('#slug').on('change', function () {
            const slug = $(this).val();
            if (slug) {
                $.post("{{ route('pages.check-slug') }}", {
                    slug: slug
                }, function (data) {
                    if (data.exists) {
                        $('#slug-error').text('This slug is already in use').show();
                    } else {
                        $('#slug-error').hide();
                    }
                });
            }
        });
    });
</script>
@endsection
@endsection
