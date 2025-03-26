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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name </label>
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $page->name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description </label>
                                                <textarea id="description" name="description" class="form-control">{{ $page->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });

        $('#update-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('pages.update', $page->id) }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.message);
                    window.location.href = "{{ route('pages.index') }}"; // Redirect to index page
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
@endsection
