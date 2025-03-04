@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

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
                          Edit Page
                          @if (isset($section))
                            {{ $section->name }}
                          @else
                          {{ $page->name }}
                          @endif
                        </h4>
                    </div>
                    <div id="error-messages" class="alert alert-danger d-none" role="alert">
                        <ul id="error-list"></ul>
                    </div>
                    <form id="update-item-form" enctype="multipart/form-data">
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
                                <input type="text" id="token" name="token" value="{{ $page->token }}" class="form-control" style="display:none">
                                <input type="text" id="page_id" name="page_id" value="{{ $page->id }}" class="form-control" style="display:none">
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
                            <button type="submit" id="update-item-form" class="btn btn-primary">Update New Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>

    const token = "{{ $page->tr_token }}";
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const selectedLanguage = $('#language-select').val();
    if (selectedLanguage) {
        const languageRow = $('.language-row');
        loadTranslationData(selectedLanguage, languageRow);
    }
});

// console.log(token)

tinymce.init({
    selector: 'textarea',
    height: 400,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | link image | code',
    branding: false,
    setup: function (editor) {
        editor.on('keyup', saveTextData);
    }
});

$('#update-item-form').on('submit', function(e) {
    e.preventDefault();
    @if (isset($section))
        const href =  "{{ route('dashboard.sections.index') }}"
        @else
        const href =  "{{ route('pages.index') }}"
        @endif
    $('#error-messages').addClass('d-none').find('#error-list').empty();

    $.ajax({
        url: "{{ route('dashboard.pages.update') }}",
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function() {
            window.location.href = href;
        },
        error: function(xhr) {
            displayErrors(xhr.responseJSON.errors);
        }
    });
});

$('#language-fields').on('keyup change', 'input, textarea, .language-select', function() {
    const languageRow = $(this).closest('.language-row');
    const selectedLanguage = languageRow.find('.language-select').val();

    if (selectedLanguage) {
        if ($(this).hasClass('language-select')) {
            loadTranslationData(selectedLanguage, languageRow);
        } else {
            saveTextData();
        }
    }
});

function saveTextData() {
    const languageRow = $('.language-row');
    const selectedLanguage = $('#language-select').val();

    const textData = {
        language_id: selectedLanguage,
        token:  "{{ $page->tr_token }}",
        description: tinyMCE.get('tt-description').getContent(),
        meta: languageRow.find('input[name="meta[]"]').val(),
        name: languageRow.find('input[name="name[]"]').val()
    };

    $.ajax({
        url: "{{ route('storeText') }}",
        type: 'POST',
        data: textData,
        success: function(response) {
            console.log('Content saved:', response);
        },
        error: function(xhr) {
            console.error('Error saving content:', xhr);
        }
    });
}

function loadTranslationData(languageId, languageRow) {
    const loader = $('<div class="loader">جاري تحميل البيانات...</div>');
    languageRow.append(loader);
    languageRow.find('input, textarea').prop('disabled', true);

    $.ajax({
        url: "{{ route('getText') }}",
        type: 'GET',
        data: { language_id: languageId, token: "{{ $page->tr_token }}" , item_id: "{{ $page->id }}" },
        success: function(response) {
            const translation = response.translations || {};
            languageRow.find('input[name="meta[]"]').val(translation.meta || '');
            languageRow.find('input[name="name[]"]').val(translation.name || '');
            tinymce.get('tt-description').setContent(translation.description || '');
        },
        error: function(xhr) {
            console.error(xhr);
        },
        complete: function() {
            loader.remove();
            languageRow.find('input, textarea').prop('disabled', false);
        }
    });
}

function displayErrors(errors) {
    $('#error-messages').removeClass('d-none');
    $.each(errors, function(key, value) {
        $('#error-list').append('<li>' + value[0] + '</li>');
    });
}

</script>
@endsection
@endsection
