@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add New Category</span>
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
                        <h5 class="card-title mb-0">Category Information</h5>
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
                                <div class="col-md-6">
                                    <label class="form-label" for="icon">Icon</label>
                                    <input type="file" id="icon" name="icon" class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label" for="color_class">Color Class</label>
                                    <input type="color" id="color_class" name="color_class" class="form-control" required>
                                </div>
                                <input type="hidden" id="token" name="token" value="{{ $token }}" class="form-control">
                            </div>

                            <h5 class="mt-4">Add Texts in Different Languages</h5>
                            <div id="language-fields">
                                <div class="language-row mb-3">
                                    <label class="form-label" for="language">Select Language</label>
                                    <select class="form-control language-select" name="language[]" required>
                                        <option value="" disabled selected>Select Language</option>
                                        @foreach($languages as $language)
                                        <option value="{{ $language->id }}" {{ defaultLanguage() == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                    @foreach ($txt as $key => $field)
                                    <label class="form-label mt-2" for="{{ $key }}">{{ $field['label'] }}</label>
                                    @if ($field['type'] === 'input')
                                    <input type="text" name="{{ $key }}[]" class="form-control" required>
                                    @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}[]" class="form-control" required></textarea>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add New Category</button>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#add-item-form').on('submit', function(e) {
        e.preventDefault();
        $('#error-messages').addClass('d-none');
        $('#error-list').empty();

        $.ajax({
            url: "{{ route('category.create') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = "{{ route('category.index') }}";
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

    $('#language-fields').on('keyup', 'input[type="text"], textarea', function(e) {
        const languageRow = $(this).closest('.language-row');
        const languageId = languageRow.find('.language-select').val();

        const textData = {
            language_id: languageId,
            token: token,
            @foreach ($txt as $key => $field)
            '{{ $key }}': languageRow.find('input[name="{{ $key }}[]"], textarea[name="{{ $key }}[]"]').val(),
            @endforeach
        };

        $.ajax({
            url: "{{ route('storeText') }}",
            type: 'POST',
            data: textData,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });

    $('#language-fields').on('change', '.language-select', function(e) {
        const languageId = $(this).val();
        const languageRow = $(this).closest('.language-row');
        const loader = $('<div class="loader">Loading data...</div>');
        languageRow.append(loader);
        const inputs = languageRow.find('input, textarea');
        inputs.prop('disabled', true);

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
                    @foreach ($txt as $key => $field)
                    languageRow.find('input[name="{{ $key }}[]"], textarea[name="{{ $key }}[]"]').val(translation['{{ $key }}'] || '');
                    @endforeach
                } else {
                    @foreach ($txt as $key => $field)
                    languageRow.find('input[name="{{ $key }}[]"], textarea[name="{{ $key }}[]"]').val('');
                    @endforeach
                }
            },
            error: function(xhr) {
                console.error(xhr);
            },
            complete: function() {
                loader.remove();
                inputs.prop('disabled', false);
            }
        });
    });
</script>
@endsection
@endsection
