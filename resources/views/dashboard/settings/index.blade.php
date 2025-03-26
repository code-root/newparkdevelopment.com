{{-- filepath: /Users/macstoreegypt/Documents/Projects/research-laznd/resources/views/dashboard/settings/index.blade.php --}}
@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- عرض رسائل النجاح والأخطاء -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Settings</span>
            </h4>

            <!-- التبويبات -->
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                        type="button" role="tab" aria-controls="general" aria-selected="true">
                        <i class="fas fa-cogs"></i> General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="slider-tab" data-bs-toggle="tab" data-bs-target="#slider" type="button"
                        role="tab" aria-controls="slider" aria-selected="false">
                        <i class="fas fa-images"></i> Slider
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button"
                        role="tab" aria-controls="social" aria-selected="false">
                        <i class="fas fa-share-alt"></i> Social Links
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                        role="tab" aria-controls="seo" aria-selected="false">
                        <i class="fas fa-search"></i> SEO Settings
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="settingsTabsContent">
                <!-- التبويب العام -->
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">General Settings</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => ['settings.update'], 'id' => 'settings-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="row mb-3">
                                <div class="mb-3">
                                    {{ Form::label('logo', 'الشعار') }}
                                    {{ Form::file('logo', ['class' => 'form-control', 'id' => 'logo']) }}
                                    @if (!empty($basic['logo']))
                                        <img src="https://newparkdevelopment.com/backend/storage/app/{{  $basic['logo'] }}" alt="Logo" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('site_name', 'Site Name') }}
                                    {{ Form::text('site_name', $basic['site_name'] ?? '', ['class' => 'form-control', 'id' => 'site_name', 'required' => true]) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('google_maps', 'google_maps') }}
                                    {{ Form::text('google_maps', $basic['google_maps'] ?? '', ['class' => 'form-control', 'id' => 'google_maps', 'required' => true]) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('phone', 'Phone Number') }}
                                    {{ Form::text('phone', $basic['phone'] ?? '', ['class' => 'form-control', 'id' => 'phone', 'required' => true]) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('email', 'Email') }}
                                    {{ Form::email('email', $basic['email'] ?? '', ['class' => 'form-control', 'id' => 'email', 'required' => true]) }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <h3 class="mb-3">Hero Section</h3>


                                <!-- زر الدعوة إلى الإجراء -->
                                <div class="mb-3">
                                    {{ Form::label('hero_cta', 'زر الدعوة إلى الإجراء (CTA)') }}
                                    {{ Form::text('hero_cta', $basic['hero_cta'] ?? 'تواصل معنا الآن', ['class' => 'form-control', 'id' => 'hero_cta']) }}
                                </div>

                                <!-- إحصائيات العقارات للإيجار -->
                                <div class="mb-3">
                                    {{ Form::label('rental_stats_count', 'عدد الشقق المتاحة للإيجار') }}
                                    {{ Form::text('rental_stats_count', $basic['rental_stats_count'] ?? '500+', ['class' => 'form-control', 'id' => 'rental_stats_count']) }}
                                </div>
                                <div class="mb-3">
                                    {{ Form::label('rental_stats_text', 'وصف إحصائيات الإيجار') }}
                                    {{ Form::text('rental_stats_text', $basic['rental_stats_text'] ?? 'شقة بمساحات مختلفة للإيجار', ['class' => 'form-control', 'id' => 'rental_stats_text']) }}
                                </div>

                                <!-- إحصائيات العقارات للشراء -->
                                <div class="mb-3">
                                    {{ Form::label('buy_stats_count', 'عدد الشقق المتاحة للشراء') }}
                                    {{ Form::text('buy_stats_count', $basic['buy_stats_count'] ?? '500+', ['class' => 'form-control', 'id' => 'buy_stats_count']) }}
                                </div>
                                <div class="mb-3">
                                    {{ Form::label('buy_stats_text', 'وصف إحصائيات الشراء') }}
                                    {{ Form::text('buy_stats_text', $basic['buy_stats_text'] ?? 'شقة بمساحات مختلفة للشراء', ['class' => 'form-control', 'id' => 'buy_stats_text']) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- تبويب السلايدر -->
                <div class="tab-pane fade" id="slider" role="tabpanel" aria-labelledby="slider-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Slider Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                {{ Form::label('slider_image', 'صورة السلايدر') }}
                                {{ Form::file('slider_image', ['class' => 'form-control', 'id' => 'slider_image']) }}
                                @if (!empty($basic['slider_image']))
                                    <img src="https://newparkdevelopment.com/backend/storage/app/{{   $basic['slider_image'] }}" alt="Slider Image" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>

                            <div class="mb-3">
                                {{ Form::label('hero_subtitle', 'العنوان الفرعي') }}
                                {{ Form::text('hero_subtitle', $basic['hero_subtitle'] ?? 'اكتشف العقارات الآن بكل سهولة', ['class' => 'form-control', 'id' => 'hero_subtitle']) }}
                            </div>
                            <div class="mb-3">
                                {{ Form::label('hero_title_1', 'العنوان الرئيسي الأول') }}
                                {{ Form::text('hero_title_1', $basic['hero_title_1'] ?? 'سواء كنت تبحث عن شراء أو إيجار', ['class' => 'form-control', 'id' => 'hero_title_1']) }}
                            </div>
                            <div class="mb-3">
                                {{ Form::label('hero_title_2', 'العنوان الرئيسي الثاني') }}
                                {{ Form::text('hero_title_2', $basic['hero_title_2'] ?? 'لدينا أفضل الخيارات لك', ['class' => 'form-control', 'id' => 'hero_title_2']) }}
                            </div>
                            <div class="mb-3">
                                {{ Form::label('hero_description', 'النص الوصفي') }}
                                {{ Form::text('hero_description', $basic['hero_description'] ?? 'العقار المناسب لك في انتظارك.. تصفح أحدث العروض!', ['class' => 'form-control', 'id' => 'hero_description']) }}
                            </div>

                        </div>
                    </div>
                </div>

                <!-- تبويب روابط التواصل الاجتماعي -->
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Social Links</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                @foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'snapchat', 'tiktok', 'x', 'whatsapp'] as $platform)
                                    <div class="col-md-4">
                                        {{ Form::label($platform, ucfirst($platform)) }}
                                        {{ Form::text($platform, $basic[$platform] ?? '', ['class' => 'form-control', 'id' => $platform]) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تبويب إعدادات SEO -->
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    {{ Form::label('meta_title', 'Meta Title') }}
                                    {{ Form::text('meta_title', $settings['meta_title'] ?? '', ['class' => 'form-control', 'id' => 'meta_title', 'required' => true]) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('meta_keywords', 'Meta Keywords') }}
                                    {{ Form::text('meta_keywords', $settings['meta_keywords'] ?? '', ['class' => 'form-control', 'id' => 'meta_keywords', 'required' => true]) }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    {{ Form::label('meta_description', 'Meta Description') }}
                                    {{ Form::textarea('meta_description', $settings['meta_description'] ?? '', ['class' => 'form-control', 'rows' => '3', 'id' => 'meta_description', 'required' => true]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- زر الإرسال -->
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-primary" id="submitSettings">Submit</button>
                </div>
            </div>

            @csrf
            {{ Form::close() }}
        </div>
    </div>

@section('footer')
    <script>
        $(document).ready(function() {
            $('#submitSettings').click(function(e) {
                e.preventDefault();
                var formData = new FormData($('#settings-form')[0]);
                $.ajax({
                    url: "{{ route('settings.update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Lobibox.notify('success', {
                            title: 'Success',
                            msg: 'Settings updated successfully.'
                        });
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr) {
                        var errors = JSON.parse(xhr.responseText).errors;
                        var errorMessages = '';
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            errorMessages += '<li>' + value + '</li>';
                        });
                        $('#error-messages').html('<div class="alert alert-danger"><ul>' +
                            errorMessages + '</ul></div>');
                    }
                });
            });
        });
    </script>
@endsection
@endsection
