@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<style>
    .faq-item {
        background-color: #f8f9fa;
    }
    .faq-item h6 {
        margin: 0;
    }
    .faq-item .form-group {
        margin-bottom: 1rem;
    }
</style>
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

        <div class="h4 py-3 mb-4">
            <span class="text-muted fw-light">Edit translations</span>
        </div>

        <div class="card">
            <div class="card-header">
                <form id="translationForm">
                    @csrf
                    @method('POST')
                    <h5>Home Translations</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>English</h6>
                            @foreach($homeTranslations['en'] as $key => $value)
                                <div class="form-group">
                                    <label for="home_en[{{ $key }}]">{{ $key }}</label>
                                    <input type="text" name="home_en[{{ $key }}]" class="form-control" value="{{ $value }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h6>Arabic</h6>
                            @foreach($homeTranslations['ar'] as $key => $value)
                                <div class="form-group">
                                    <label for="home_ar[{{ $key }}]">{{ $key }}</label>
                                    <input type="text" name="home_ar[{{ $key }}]" class="form-control" value="{{ $value }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h5 class="mt-4">FAQ Translations</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>English</h6>
                            <div id="faq_en_container">
                                @foreach($faqTranslations['en'] as $index => $faq)
                                    <div class="faq-item" data-index="{{ $index }}">
                                        <div class="form-group">
                                            <label for="faq_en[{{ $index }}][question]">Question</label>
                                            <input type="text" name="faq_en[{{ $index }}][question]" class="form-control" value="{{ $faq['question'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="faq_en[{{ $index }}][answer]">Answer</label>
                                            <input type="text" name="faq_en[{{ $index }}][answer]" class="form-control" value="{{ $faq['answer'] }}">
                                        </div>
                                        <button type="button" class="btn btn-danger remove-faq-btn">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-success add-faq-btn" data-lang="en">Add FAQ</button>
                        </div>
                        <div class="col-md-6">
                            <h6>Arabic</h6>
                            <div id="faq_ar_container">
                                @foreach($faqTranslations['ar'] as $index => $faq)
                                    <div class="faq-item" data-index="{{ $index }}">
                                        <div class="form-group">
                                            <label for="faq_ar[{{ $index }}][question]">Question</label>
                                            <input type="text" name="faq_ar[{{ $index }}][question]" class="form-control" value="{{ $faq['question'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="faq_ar[{{ $index }}][answer]">Answer</label>
                                            <input type="text" name="faq_ar[{{ $index }}][answer]" class="form-control" value="{{ $faq['answer'] }}">
                                        </div>
                                        <button type="button" class="btn btn-danger remove-faq-btn">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-success add-faq-btn" data-lang="ar">Add FAQ</button>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('footer')

<script>
    $(document).ready(function() {
        let faqIndexEn = {{ count($faqTranslations['en']) }};
        let faqIndexAr = {{ count($faqTranslations['ar']) }};

        $('.add-faq-btn').on('click', function() {
            let lang = $(this).data('lang');
            let container = $('#faq_' + lang + '_container');
            let index = lang === 'en' ? faqIndexEn++ : faqIndexAr++;

            let newFaq = `
                <div class="faq-item mb-3 p-3 border rounded" data-index="${index}">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>FAQ ${index + 1}</h6>
                        <button type="button" class="btn btn-danger btn-sm remove-faq-btn">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                    <div class="form-group mt-3">
                        <label for="faq_${lang}[${index}][question]">Question</label>
                        <input type="text" name="faq_${lang}[${index}][question]" class="form-control" value="">
                    </div>
                    <div class="form-group mt-3">
                        <label for="faq_${lang}[${index}][answer]">Answer</label>
                        <input type="text" name="faq_${lang}[${index}][answer]" class="form-control" value="">
                    </div>
                </div>
            `;
            container.append(newFaq);
        });

        $(document).on('click', '.remove-faq-btn', function() {
            $(this).closest('.faq-item').remove();
        });

        $('#translationForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('translations.update') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                       swal({
                        icon: 'success',
                        title: 'Success',
                        text: 'Translations updated successfully!'
                    });
                },
                error: function(response) {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating translations.'
                    });
                }
            });
        });
    });
</script>

@endsection
@endsection
