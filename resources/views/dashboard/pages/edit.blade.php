@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<script src="https://cdn.tiny.cloud/1/no-origin/tinymce/7.3.0-86/tinymce.min.js" referrerpolicy="origin"></script>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit </span><span>Page</span>
        </h4>

        <div class="app-ecommerce">
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

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Edit Page Settings</div>
                            <div class="card-body">
                                <form id="update-form">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" id="page-id" name="id" value="{{ $page->id }}">

                                    <!-- Basic Information Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">Basic Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="type" class="form-label">Page Type *</label>
                                                    <select id="type" name="type" class="form-select" required>
                                                        <option value="regular" {{ $page->type == 'regular' ? 'selected' : '' }}>Regular Page</option>
                                                        <option value="section" {{ $page->type == 'section' ? 'selected' : '' }}>Section</option>
                                                        <option value="article" {{ $page->type == 'article' ? 'selected' : '' }}>Article</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="name" class="form-label">Page Name *</label>
                                                    <input type="text" id="name" name="name" class="form-control" value="{{ $page->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="slug" class="form-label">URL Slug *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="slug" name="slug" class="form-control" value="{{ $page->slug }}" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="generate-slug">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">Unique identifier for the page URL</small>
                                                    <div id="slug-error" class="text-danger small"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="description" class="form-label">Page Content</label>
                                                    <textarea id="description" name="description" class="form-control">{{ $page->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEO Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">SEO Settings</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $page->meta_title ?? '' }}" placeholder="Title for search engines (50-60 characters)">
                                                    <small class="text-muted">Recommended length: 50-60 characters</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Description for search engines (150-160 characters)">{{ $page->meta_description ?? '' }}</textarea>
                                                    <small class="text-muted">Recommended length: 150-160 characters</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="images" class="form-label">Page Images</label>
                                            <input type="file" name="images[]" id="images" class="form-control" multiple>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($page->images as $image)
                                            <div class="col-md-2 mb-3" id="image-{{ $image->id }}">
                                                <img src="/backend/storage/{{  $image->image }}" class="img-fluid" />
                                                <button type="button" class="btn btn-danger btn-sm mt-1 delete-image" data-id="{{ $image->id }}">Delete</button>
                                            </div>
                                        @endforeach
                                    </div>


                                    <button type="submit" class="btn btn-primary">Update Page</button>
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });

        $('.delete-image').on('click', function () {
    let id = $(this).data('id');
    $.ajax({
        url: '/dashboard/pages/images/' + id,
        type: 'DELETE',
        data: {_token: '{{ csrf_token() }}'},
        success: function (res) {
            $('#image-' + id).remove();
        }
    });
});

        // Generate slug from name
        $('#generate-slug').click(function() {
            const name = $('#name').val();
            if(name) {
                $.post("{{ route('pages.check-slug') }}", {
                    name: name,
                    id: $('#page-id').val()
                }, function(data) {
                    $('#slug').val(data.slug);
                    $('#slug-error').hide();
                });
            }
        });

        // Validate slug on change
        $('#slug').on('change', function() {
            const slug = $(this).val();
            if(slug) {
                $.post("{{ route('pages.check-slug') }}", {
                    slug: slug,
                    id: $('#page-id').val()
                }, function(data) {
                    if(data.exists) {
                        $('#slug-error').text('This slug is already in use').show();
                    } else {
                        $('#slug-error').hide();
                    }
                });
            }
        });

        $('#update-form').submit(function(e) {
            e.preventDefault();

            // Validate slug before submission
            const slug = $('#slug').val();
            if(!slug) {
                $('#slug-error').text('Slug is required').show();
                return false;
            }

            $.ajax({
                url: "{{ route('pages.update', $page->id) }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.message);
                    window.location.href = "{{ route('pages.index') }}";
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if(errors.slug) {
                        $('#slug-error').text(errors.slug[0]).show();
                    }
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
@endsection
