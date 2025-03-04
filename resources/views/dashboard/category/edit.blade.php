@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Category</span>
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
                    <form method="post" action="{{ route('category.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>On display</option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="icon">Icon</label>
                                    <input type="file" id="icon" name="icon" class="form-control">
                                    @if($data->icon)
                                    <div class="mt-2">
                                        <img src="{{ asset('/storage/app/public/' . $data->icon) }}" alt="Icon" style="max-width: 100px;">
                                        <button type="button" class="btn btn-danger btn-sm" id="delete-icon">Delete</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label" for="color_class">Color Class</label>
                                    <input type="color" id="color_class" name="color_class" class="form-control" value="{{ $data->color_class }}" required>
                                </div>
                            </div>

                            <h5 class="mt-4">Edit Texts in Different Languages</h5>
                            <div class="mb-3">
                                <label class="form-label" for="language">Select Language</label>
                                <select id="language" name="language_id" class="form-control" required>
                                    @foreach($languages as $language)
                                         <option value="{{ $language->id }}" {{ defaultLanguage() == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="language-fields">
                                <!-- سيتم ملء الحقول هنا بواسطة الجافاسكريبت -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Category</button>
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

function saveTextData() {
    const languageRow = $('.language-row');
    const selectedLanguage = $('#language-select').val();

    const textData = {
        language_id: selectedLanguage,
        token:  "{{ $data->tr_token }}",
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
$(document).ready(function() {
    // عند تغيير اللغة
    $('#language').change(function() {
        var languageId = $(this).val();
        var item_id = {{ $data->id }}; // الحصول على ID category

        $.ajax({
            url: "{{ route('category.getTranslations') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'language_id': languageId,
                'item_id': item_id
            },
            success: function(translations) {
                // مسح الحقول الحالية
                $('#language-fields').empty();

                // إضافة الحقول الجديدة
                translations.forEach(function(translation) {
                    // تحقق من أن المفتاح ليس 'language_id' أو 'token'
                    if (translation.key !== 'language_id' && translation.key !== 'token') {
                        var fieldHtml = `
                            <div class="language-row mb-3">
                                <label class="form-label mt-2" for="${translation.key}">${translation.key}</label>
                                <input type="text" name="${translation.key}[${translation.language_id}]" class="form-control" value="${translation.value || ''}" required>
                            </div>
                        `;
                        $('#language-fields').append(fieldHtml);
                    }
                });

                // إذا كانت الترجمة فارغة، استخدم $txt
                if (translations.length === 0) {
                    @foreach ($txt as $key => $field)
                        var fieldHtml = `
                            <div class="language-row mb-3">
                                <label class="form-label mt-2" for="{{ $key }}">{{ $field['label'] }}</label>
                                @if ($field['type'] === 'input')
                                    <input type="text" name="{{ $key }}[${languageId}]" class="form-control" value="" required>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea name="{{ $key }}[${languageId}]" class="form-control" required></textarea>
                                @endif
                            </div>
                        `;
                        $('#language-fields').append(fieldHtml);
                    @endforeach
                }
            }
        });
    });


});
</script>
@endsection
@endsection
