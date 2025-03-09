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

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Settings</h5>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => ['settings.update'], 'id' => 'settings-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <!-- اختيار اللغة -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('language', 'Language') }}
                        {{ Form::select('language', $languages->pluck('name', 'code'), null, ['class' => 'form-control', 'id' => 'language-select']) }}
                    </div>
                </div>


                <!-- بيانات الموقع الأساسية -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('site_name', 'Site Name') }}
                        {{ Form::text('site_name', $basic['site_name'] ?? '', ['class' => 'form-control', 'id' => 'site_name']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('phone', 'Phone Number') }}
                        {{ Form::text('phone', $basic['phone'] ?? '', ['class' => 'form-control', 'id' => 'phone']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('email', 'Email') }}
                        {{ Form::email('email', $basic['email'] ?? '', ['class' => 'form-control', 'id' => 'email']) }}
                    </div>
                </div>

                <!-- الصور والشعارات -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        {{ Form::label('logo', 'Logo') }}
                        {{ Form::file('logo', ['class' => 'form-control']) }}
                    </div>
                </div>

                <!-- وصف الموقع -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        {{ Form::label('footer_description', 'Footer Description') }}
                        {{ Form::textarea('footer_description', $settings['footer_description'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'footer_description']) }}
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('about_us', 'About Us') }}
                        {{ Form::textarea('about_us', $settings['about_us'] ?? '', ['class' => 'form-control', 'rows'=> '2', 'id' => 'about_us']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('about_intro', 'about Intro') }}
                        {{ Form::textarea('about_intro', $settings['about_intro'] ?? '', ['class' => 'form-control', 'id' => 'about_intro']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('about_mission', 'about Mission') }}
                        {{ Form::textarea('about_mission', $settings['about_mission'] ?? '', ['class' => 'form-control', 'id' => 'about_mission']) }}
                </div>
                    <div class="col-md-4">
                        {{ Form::label('faq_title', 'faq_title') }}
                        {{ Form::textarea('faq_title', $settings['faq_title'] ?? '', ['class' => 'form-control', 'id' => 'faq_title']) }}
                </div>
                </div>



                <div class="mb-4">
                    <h3 class="mb-3">Hero Section</h3>
                    
                    <!-- العنوان الفرعي -->
                    <div class="mb-3">
                        {{ Form::label('hero_subtitle', 'العنوان الفرعي') }}
                        {{ Form::text('hero_subtitle', $basic['hero_subtitle'] ?? 'اكتشف العقارات الآن بكل سهولة', ['class' => 'form-control', 'id' => 'hero_subtitle']) }}
                    </div>

                    <!-- العنوان الرئيسي الأول -->
                    <div class="mb-3">
                        {{ Form::label('hero_title_1', 'العنوان الرئيسي الأول') }}
                        {{ Form::text('hero_title_1', $basic['hero_title_1'] ?? 'سواء كنت تبحث عن شراء أو إيجار', ['class' => 'form-control', 'id' => 'hero_title_1']) }}
                    </div>

                    <!-- العنوان الرئيسي الثاني -->
                    <div class="mb-3">
                        {{ Form::label('hero_title_2', 'العنوان الرئيسي الثاني') }}
                        {{ Form::text('hero_title_2', $basic['hero_title_2'] ?? 'لدينا أفضل الخيارات لك', ['class' => 'form-control', 'id' => 'hero_title_2']) }}
                    </div>

                    <!-- النص الوصفي -->
                    <div class="mb-3">
                        {{ Form::label('hero_description', 'النص الوصفي') }}
                        {{ Form::text('hero_description', $basic['hero_description'] ?? 'العقار المناسب لك في انتظارك.. تصفح أحدث العروض!', ['class' => 'form-control', 'id' => 'hero_description']) }}
                    </div>

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


                <!-- روابط التواصل الاجتماعي -->
                <div class="row mb-3">
                    @foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'snapchat', 'tiktok', 'x', 'whatsapp'] as $platform)
                    <div class="col-md-4">
                        {{ Form::label($platform, ucfirst($platform)) }}
                        {{ Form::text($platform, $basic[$platform] ?? '', ['class' => 'form-control', 'id' => $platform]) }}
                    </div>
                    @endforeach
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
    </div>
</div>

@section('footer')
<script>
$(document).ready(function() {
    $('#language-select').change(function() {
        var selectedLanguage = $(this).val();
        $.ajax({
            url: "{{ route('settings.getFields') }}",
            type: 'GET',
            data: { language: selectedLanguage },
            success: function(data) {

        $('#footer_description').val(data.footer_description);
        $('#about_us').val(data.about_us);
        $('#about_intro').val(data.about_intro);
        $('#about_mission').val(data.about_mission);
        $('#faq_title').val(data.faq_title);
        $('#banner_title').val(data.banner_title);
        $('#banner_description').val(data.banner_description);
        $('#banner_button_text').val(data.banner_button_text);
        $('#site_name').val(data.site_name);
        $('#phone').val(data.phone);
        $('#email').val(data.email);
        $('#hero_subtitle').val(data.hero_subtitle);
        $('#hero_title_1').val(data.hero_title_1);
        $('#hero_title_2').val(data.hero_title_2);
        $('#hero_description').val(data.hero_description);
        $('#hero_cta').val(data.hero_cta);
        $('#rental_stats_count').val(data.rental_stats_count);
        $('#rental_stats_text').val(data.rental_stats_text);
        $('#buy_stats_count').val(data.buy_stats_count);
        $('#buy_stats_text').val(data.buy_stats_text);

        }
        });
    });

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
                $('#error-messages').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
            }
        });
    });
});
</script>
@endsection
@endsection
