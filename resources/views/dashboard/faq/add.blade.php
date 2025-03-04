@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">add new item</span>
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
                        <h5 class="card-title mb-0">Info Category</h5>
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
                                        <option value="0">hidden</option>
                                    </select>
                                </div>
                                <input type="txt" id="token" name="token" value="{{ $token }}" class="form-control"  style="display:none">
                            </div>

                            <h5 class="mt-4">Add texts in different languages</h5>
                            <div id="language-fields">
                                <div class="language-row mb-3">
                                    <label class="form-label" for="language">Select language</label>
                                    <select class="form-control language-select" name="language[]" required>
                                        <option value="" disabled selected>اختر لغة</option>
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
                            <button type="submit" class="btn btn-primary">add new item</button>
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
            e.preventDefault(); // منع الإرسال الافتراضي للنموذج
            // إخفاء رسائل الخطأ السابقة
            $('#error-messages').addClass('d-none');
            $('#error-list').empty();

            // إرسال البيانات باستخدام AJAX
            $.ajax({
                url: "{{ route('faq.create') }}",
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    // إعادة توجيه أو عرض رسالة نجاح
                    window.location.href = "{{ route('faq.index') }}"; // إعادة التوجيه إلى صفحة السلايدر
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
    // تخزين الtxt عند الانتهاء من الكتابة باستخدام keyup
    document.getElementById('language-fields').addEventListener('keyup', function(e) {
        if (e.target.matches('input[type="text"], textarea')) {
            const languageRow = e.target.closest('.language-row');
            const languageId = languageRow.querySelector('.language-select').value;

            const textData = {
                language_id: languageId,
                token: token,
                @foreach ($txt as $key => $field)
                    '{{ $key }}': (function() {
                        const inputField = languageRow.querySelector('input[name="{{ $key }}[]"]');
                        const textareaField = languageRow.querySelector('textarea[name="{{ $key }}[]"]');
                        return inputField ? inputField.value : textareaField.value;
                    })(),
                @endforeach
            };

            // استدعاء دالة التخزين
            $.ajax({
                url: "{{ route('storeText') }}",
                type: 'POST',
                data: textData,
                success: function(response) {
                    console.log(response.message);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
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
                        @foreach ($txt as $key => $field)
            if (translation['{{ $key }}']) {
                if ('{{ $field['type'] }}' === 'input') {
                    languageRow.querySelector('input[name="{{ $key }}[]"]').value = translation['{{ $key }}'] || '';
                } else if ('{{ $field['type'] }}' === 'textarea') {
                    languageRow.querySelector('textarea[name="{{ $key }}[]"]').value = translation['{{ $key }}'] || '';
                }
            }
        @endforeach
    } else {
        // إذا لم توجد ترجمة، يمكنك مسح الحقول
        @foreach ($txt as $key => $field)
            if ('{{ $field['type'] }}' === 'input') {
                languageRow.querySelector('input[name="{{ $key }}[]"]').value = '';
            } else if ('{{ $field['type'] }}' === 'textarea') {
                languageRow.querySelector('textarea[name="{{ $key }}[]"]').value = '';
            }
        @endforeach
    }
                },
                error: function(xhr) {
                    console.error(xhr);
                },
                complete: function() {
                    // إزالة اللودر
                    loader.remove();
                    // إعادة تفعيل الحقول
                    inputs.forEach(input => input.disabled = false);
                }
            });
        }
    });
</script>
@endsection
@endsection
