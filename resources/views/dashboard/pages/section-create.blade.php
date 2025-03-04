@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<script src="https://cdn.tiny.cloud/1/no-origin/tinymce/7.3.0-86/tinymce.min.js" referrerpolicy="origin"></script>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

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
                        <h4 class="py-3 mb-4">
                            Add New Item Section
                            @if (isset($section))
                              {{ $section->name }}
                            @endif
                        </h4>
                    </div>
                    <div id="error-messages" class="alert alert-danger d-none" role="alert">
                        <ul id="error-list"></ul>
                    </div>
                    <form id="add-item-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1">On display</option>
                                        <option value="0">Hidden</option>
                                    </select>
                                </div>
                                <input type="text" id="token" name="token" value="{{ $token }}" class="form-control" style="display:none">
                            </div>

                            <h5 class="mt-4">Add Texts in Different Languages</h5>
                            <div id="language-fields">
                                <div class="language-row mb-3">
                                    <label class="form-label" for="language">Select Language</label>
                                    <select class="form-control language-select" name="language[]" required id="language-select">
                                        <option value="" disabled selected>اختر لغة</option>
                                        @foreach($languages as $language)
                                         <option value="{{ $language->id }}" {{ defaultLanguage() == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label mt-2" for="meta">Meta</label>
                                    <input type="text" name="meta[]" class="form-control" required>
                                    <label class="form-label mt-2" for="name">Name Section</label>
                                    <input type="text" name="name[]" class="form-control" required>
                                    <label class="form-label mt-2" for="description">Description</label>
                                    <textarea id="tt-description" name="description[]" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="add-item-form" class="btn btn-primary">Add New Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
    const token = "{{ $token }}";
    tinymce.init({
        selector: 'textarea',
        height: 400,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | link image | code',
        branding: false,
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#add-item-form').on('submit', function(e) {
        @if (isset($section))
        const url_save =  "{{ route('dashboard.section.page.save' , ['section_id' => $section->id]) }}"
        const href =  "{{ route('dashboard.sections.index') }}"
        @else
        const url_save =  "{{ route('dashboard.pages.save') }}"
        const href =  "{{ route('pages.index') }}"
        @endif
            e.preventDefault();
            $('#error-messages').addClass('d-none');
            $('#error-list').empty();
            $.ajax({
                url: url_save,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location.href =href;
                },
                error: function(xhr) {
                    // عرض رسائل الخطأ
                    $('#error-messages').removeClass('d-none');
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error-list').append('<li>' + value[0] + '</li>');
                    });
                }
            });
        });

    document.getElementById('language-fields').addEventListener('keyup', function(e) {
        if (e.target.matches('input[type="text"], textarea')) {
            const languageRow = e.target.closest('.language-row');
            const languageId = languageRow.querySelector('.language-select').value;
            const textData = {
                language_id: languageId,
                token: token,
                description: tinyMCE.get('tt-description').getContent() ?? '',
                meta: languageRow.querySelector('input[name="meta[]"]').value ?? '',
                name: languageRow.querySelector('input[name="name[]"]').value ?? '',
            };
            $.ajax({
                url: "{{ route('storeText') }}",
                type: 'POST',
                data: textData,
            });
        }
    });

    // استرجاع الtxt عند اختيار لغة
    document.getElementById('language-fields').addEventListener('change', function(e) {
        if (e.target.classList.contains('language-select')) {
            const languageId = e.target.value;
            const languageRow = e.target.closest('.language-row');
            const loader = document.createElement('div');
            loader.className = 'loader';
            loader.innerHTML = 'جاري تحميل البيانات...';
            languageRow.appendChild(loader);
            const inputs = languageRow.querySelectorAll('input, textarea');
            inputs.forEach(input => input.disabled = true);

            $.ajax({
                url: "{{ route('getText') }}",
                type: 'GET',
                data: {
                    language_id: languageId,
                    token: token
                },
                success: function(response) {
                    const translation = response.translations;
                    if (response.empty == 200) {
                        languageRow.querySelector('input[name="meta[]"]').value = translation['meta'] || '';
                        languageRow.querySelector('input[name="name[]"]').value = translation['name'] || '';
                        tinymce.get('tt-description').setContent(translation['description'] || '');
                    } else {
                        languageRow.querySelector('input[name="meta[]"]').value = '';
                        languageRow.querySelector('input[name="name[]"]').value = '';
                        tinymce.get('tt-description').setContent('');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                },
                complete: function() {
                    loader.remove();
                    inputs.forEach(input => input.disabled = false);
                }
            });
        }
    });
</script>
@endsection
@endsection
