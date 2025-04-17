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
                                        <img src="{{ asset('storage/'.$basic['logo']) }}" alt="Logo" class="img-thumbnail mt-2" width="150">
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

                                <!-- Main Title -->
                                <div class="mb-3">
                                    {{ Form::label('main_title', 'العنوان الرئيسي') }}
                                    {{ Form::text('main_title', $basic['main_title'] ?? 'المبدع للسداد', ['class' => 'form-control', 'id' => 'main_title']) }}
                                </div>

                                <!-- Subtitle -->
                                <div class="mb-3">
                                    {{ Form::label('subtitle', 'العنوان الفرعي') }}
                                    {{ Form::text('subtitle', $basic['subtitle'] ?? 'وجهتك الأولى لحلول القروض والتمويل', ['class' => 'form-control', 'id' => 'subtitle']) }}
                                </div>

                                <!-- Feature List 1 -->
                                <div class="mb-3">
                                    {{ Form::label('feature1', 'الميزة الأولى') }}
                                    {{ Form::text('feature1', $basic['feature1'] ?? 'سداد قروض واستخراج تمويل يصل إلى 32 راتب', ['class' => 'form-control', 'id' => 'feature1']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature2', 'الميزة الثانية') }}
                                    {{ Form::text('feature2', $basic['feature2'] ?? 'سداد متعثرات وايقاف الخدمات والمخالفات المرورية', ['class' => 'form-control', 'id' => 'feature2']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature3', 'الميزة الثالثة') }}
                                    {{ Form::text('feature3', $basic['feature3'] ?? 'بطريقه متوافقة 100٪مع الشريعة الإسلامية.', ['class' => 'form-control', 'id' => 'feature3']) }}
                                </div>

                                <!-- Advantages Title -->
                                <div class="mb-3">
                                    {{ Form::label('advantages_title', 'عنوان المميزات') }}
                                    {{ Form::text('advantages_title', $basic['advantages_title'] ?? 'وش اللي يميزنا؟', ['class' => 'form-control', 'id' => 'advantages_title']) }}
                                </div>

                                <!-- Advantages List -->
                                <div class="mb-3">
                                    {{ Form::label('advantage1', 'الميزة الأولى') }}
                                    {{ Form::text('advantage1', $basic['advantage1'] ?? 'أقل نسبة فائدة بالسوق – وبدون أي تلاعب أو استغلال.', ['class' => 'form-control', 'id' => 'advantage1']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('advantage2', 'الميزة الثانية') }}
                                    {{ Form::text('advantage2', $basic['advantage2'] ?? 'تمويل حتى 32 راتب من البنوك والشركات.', ['class' => 'form-control', 'id' => 'advantage2']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('advantage3', 'الميزة الثالثة') }}
                                    {{ Form::text('advantage3', $basic['advantage3'] ?? 'نسدد عنك المتعثرات، سواء كانت بنكية، بطاقات، أو حتى مخالفات مرورية.', ['class' => 'form-control', 'id' => 'advantage3']) }}
                                </div>

                                <!-- Slider Text -->
                                <div class="mb-3">
                                    {{ Form::label('slider_text1', 'نص السلايدر 1') }}
                                    {{ Form::text('slider_text1', $basic['slider_text1'] ?? 'متواجدين في أكثر من 7 مدن لخدمتك في أي وقت.', ['class' => 'form-control', 'id' => 'slider_text1']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text2', 'نص السلايدر 2') }}
                                    {{ Form::text('slider_text2', $basic['slider_text2'] ?? 'سرعة، ثقة، وخصوصية تامة – نتعامل مع حالتك وكأنها حالتنا.', ['class' => 'form-control', 'id' => 'slider_text2']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text3', 'نص السلايدر 3') }}
                                    {{ Form::text('slider_text3', $basic['slider_text3'] ?? 'استشارات مجانية من فريق خبير ومتمرس.', ['class' => 'form-control', 'id' => 'slider_text3']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text4', 'نص السلايدر 4') }}
                                    {{ Form::text('slider_text4', $basic['slider_text4'] ?? 'نرفع إيقاف الخدمات بشكل سريع وفعّال.', ['class' => 'form-control', 'id' => 'slider_text4']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text5', 'نص السلايدر 5') }}
                                    {{ Form::text('slider_text5', $basic['slider_text5'] ?? 'سداد المخالفات المرورية', ['class' => 'form-control', 'id' => 'slider_text5']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text6', 'نص السلايدر 6') }}
                                    {{ Form::text('slider_text6', $basic['slider_text6'] ?? 'سداد القروض والشركات', ['class' => 'form-control', 'id' => 'slider_text6']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text7', 'نص السلايدر 7') }}
                                    {{ Form::text('slider_text7', $basic['slider_text7'] ?? 'سداد ايقاف الخدمات', ['class' => 'form-control', 'id' => 'slider_text7']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('slider_text8', 'نص السلايدر 8') }}
                                    {{ Form::text('slider_text8', $basic['slider_text8'] ?? 'سداد متعثرات سمة', ['class' => 'form-control', 'id' => 'slider_text8']) }}
                                </div>

                                <!-- About Section -->
                                <div class="mb-3">
                                    {{ Form::label('about_title', 'عنوان قسم من نحن') }}
                                    {{ Form::text('about_title', $basic['about_title'] ?? 'من هو سداد؟', ['class' => 'form-control', 'id' => 'about_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('about_description', 'وصف قسم من نحن') }}
                                    {{ Form::textarea('about_description', $basic['about_description'] ?? 'سداد هو الحل الأمثل ! نوفر لك خيارات تمويل مرنة، بدون فوائد مخفية، وبموافقة سريعة، حتى تقدر تحصل على احتياجاتك بدون أي تعقيدات', ['class' => 'form-control', 'rows' => 3, 'id' => 'about_description']) }}
                                </div>

                                <!-- Features Section -->
                                <div class="mb-3">
                                    {{ Form::label('features_title', 'عنوان قسم المميزات') }}
                                    {{ Form::text('features_title', $basic['features_title'] ?? 'مزایا سداد', ['class' => 'form-control', 'id' => 'features_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('features_subtitle', 'وصف قسم المميزات') }}
                                    {{ Form::text('features_subtitle', $basic['features_subtitle'] ?? 'وداعا لإيقاف الخدمات والمخالفات والمتعثرات', ['class' => 'form-control', 'id' => 'features_subtitle']) }}
                                </div>

                                <!-- Features Items -->
                                <div class="mb-3">
                                    {{ Form::label('feature_item1_title', 'عنوان الميزة 1') }}
                                    {{ Form::text('feature_item1_title', $basic['feature_item1_title'] ?? 'موافقة سريعة', ['class' => 'form-control', 'id' => 'feature_item1_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item1_desc', 'وصف الميزة 1') }}
                                    {{ Form::text('feature_item1_desc', $basic['feature_item1_desc'] ?? 'احصل علي تمويلك خلال ساعات', ['class' => 'form-control', 'id' => 'feature_item1_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item2_title', 'عنوان الميزة 2') }}
                                    {{ Form::text('feature_item2_title', $basic['feature_item2_title'] ?? 'بدون فوائد خفية', ['class' => 'form-control', 'id' => 'feature_item2_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item2_desc', 'وصف الميزة 2') }}
                                    {{ Form::text('feature_item2_desc', $basic['feature_item2_desc'] ?? 'شفافية تامة في الأسعار وخطط السداد', ['class' => 'form-control', 'id' => 'feature_item2_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item3_title', 'عنوان الميزة 3') }}
                                    {{ Form::text('feature_item3_title', $basic['feature_item3_title'] ?? 'خطط سداد آمنة', ['class' => 'form-control', 'id' => 'feature_item3_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item3_desc', 'وصف الميزة 3') }}
                                    {{ Form::text('feature_item3_desc', $basic['feature_item3_desc'] ?? 'اختر الخطة التي تناسبك', ['class' => 'form-control', 'id' => 'feature_item3_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item4_title', 'عنوان الميزة 4') }}
                                    {{ Form::text('feature_item4_title', $basic['feature_item4_title'] ?? 'أمان وحماية تامة', ['class' => 'form-control', 'id' => 'feature_item4_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('feature_item4_desc', 'وصف الميزة 4') }}
                                    {{ Form::text('feature_item4_desc', $basic['feature_item4_desc'] ?? 'بياناتك ومعلوماتك المالية بأعلى معايير الأمان', ['class' => 'form-control', 'id' => 'feature_item4_desc']) }}
                                </div>

                                <!-- Services Section -->
                                <div class="mb-3">
                                    {{ Form::label('services_title', 'عنوان قسم الخدمات') }}
                                    {{ Form::text('services_title', $basic['services_title'] ?? 'خدمات سداد', ['class' => 'form-control', 'id' => 'services_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('services_subtitle', 'وصف قسم الخدمات') }}
                                    {{ Form::text('services_subtitle', $basic['services_subtitle'] ?? 'وداعا لإيقاف الخدمات والمخالفات والمتعثرات', ['class' => 'form-control', 'id' => 'services_subtitle']) }}
                                </div>

                                <!-- Service Items -->
                                <div class="mb-3">
                                    {{ Form::label('service1_title', 'عنوان الخدمة 1') }}
                                    {{ Form::text('service1_title', $basic['service1_title'] ?? 'تسديد القروض في جميع البنوك', ['class' => 'form-control', 'id' => 'service1_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service1_desc', 'وصف الخدمة 1') }}
                                    {{ Form::textarea('service1_desc', $basic['service1_desc'] ?? 'هدفنا مساعده العميل فنسعى جاهدين لتوفير كل السبل الممكنة التي تؤهلنا إلى سداد القروض لجميع البنوك الموجودة في السعودية.', ['class' => 'form-control', 'rows' => 3, 'id' => 'service1_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service2_title', 'عنوان الخدمة 2') }}
                                    {{ Form::text('service2_title', $basic['service2_title'] ?? 'تسديد قروض العسكريين والمدنيين', ['class' => 'form-control', 'id' => 'service2_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service2_desc', 'وصف الخدمة 2') }}
                                    {{ Form::textarea('service2_desc', $basic['service2_desc'] ?? 'تسديد قروض العسكريين والمدنيين في جميع مناطق المملكة', ['class' => 'form-control', 'rows' => 3, 'id' => 'service2_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service3_title', 'عنوان الخدمة 3') }}
                                    {{ Form::text('service3_title', $basic['service3_title'] ?? 'سداد المديونيات والمتعثرات', ['class' => 'form-control', 'id' => 'service3_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service3_desc', 'وصف الخدمة 3') }}
                                    {{ Form::textarea('service3_desc', $basic['service3_desc'] ?? 'نسعى إلى سداد الديون الخاصة بالمتعثرين من خلال نظام محدد.', ['class' => 'form-control', 'rows' => 3, 'id' => 'service3_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service4_title', 'عنوان الخدمة 4') }}
                                    {{ Form::text('service4_title', $basic['service4_title'] ?? 'استخراج بنك التنمية (بنك التسليف)', ['class' => 'form-control', 'id' => 'service4_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service4_desc', 'وصف الخدمة 4') }}
                                    {{ Form::textarea('service4_desc', $basic['service4_desc'] ?? 'قرض العمل الحر وقرض الزواج', ['class' => 'form-control', 'rows' => 3, 'id' => 'service4_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service5_title', 'عنوان الخدمة 5') }}
                                    {{ Form::text('service5_title', $basic['service5_title'] ?? 'تسديد إيقاف الخدمات', ['class' => 'form-control', 'id' => 'service5_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service5_desc', 'وصف الخدمة 5') }}
                                    {{ Form::textarea('service5_desc', $basic['service5_desc'] ?? 'إيقاف الخدمات يسبب الكثير من العوائق، فقد وفرنا لك إمكانية السداد بطريقة آمنة.', ['class' => 'form-control', 'rows' => 3, 'id' => 'service5_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service6_title', 'عنوان الخدمة 6') }}
                                    {{ Form::text('service6_title', $basic['service6_title'] ?? 'استخراج ما يصل إلى ٣٢ راتب', ['class' => 'form-control', 'id' => 'service6_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service6_desc', 'وصف الخدمة 6') }}
                                    {{ Form::textarea('service6_desc', $basic['service6_desc'] ?? 'تتيح لك تلك الخدمة الحصول فرصة التمويل بنسبة محددة حتى نقوم بالسداد.', ['class' => 'form-control', 'rows' => 3, 'id' => 'service6_desc']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service7_title', 'عنوان الخدمة 7') }}
                                    {{ Form::text('service7_title', $basic['service7_title'] ?? 'خدماتنا مقدمة للعسكريين والمدنيين فقط', ['class' => 'form-control', 'id' => 'service7_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('service7_desc', 'وصف الخدمة 7') }}
                                    {{ Form::textarea('service7_desc', $basic['service7_desc'] ?? 'نود التنويه على تلك النقطة وهي أن خدماتنا موجهة فقط للعسكريين والمدنيين.', ['class' => 'form-control', 'rows' => 3, 'id' => 'service7_desc']) }}
                                </div>

                                <!-- Stats Section -->
                                <div class="mb-3">
                                    {{ Form::label('stats_title', 'عنوان قسم الإحصائيات') }}
                                    {{ Form::text('stats_title', $basic['stats_title'] ?? 'أرقامنا تحكي عنا', ['class' => 'form-control', 'id' => 'stats_title']) }}
                                </div>

                                <!-- Stat Items -->
                                <div class="mb-3">
                                    {{ Form::label('stat1_value', 'قيمة الإحصائية 1') }}
                                    {{ Form::text('stat1_value', $basic['stat1_value'] ?? '95%', ['class' => 'form-control', 'id' => 'stat1_value']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat1_label', 'وصف الإحصائية 1') }}
                                    {{ Form::text('stat1_label', $basic['stat1_label'] ?? 'نسبة الموافقات السريعة', ['class' => 'form-control', 'id' => 'stat1_label']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat2_value', 'قيمة الإحصائية 2') }}
                                    {{ Form::text('stat2_value', $basic['stat2_value'] ?? '+500', ['class' => 'form-control', 'id' => 'stat2_value']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat2_label', 'وصف الإحصائية 2') }}
                                    {{ Form::text('stat2_label', $basic['stat2_label'] ?? 'يوجد لدينا فروع في جميع انحاء المملكه', ['class' => 'form-control', 'id' => 'stat2_label']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat3_value', 'قيمة الإحصائية 3') }}
                                    {{ Form::text('stat3_value', $basic['stat3_value'] ?? '٣٢', ['class' => 'form-control', 'id' => 'stat3_value']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat3_label', 'وصف الإحصائية 3') }}
                                    {{ Form::text('stat3_label', $basic['stat3_label'] ?? 'تمويل يصل إلى ٣٢ راتب', ['class' => 'form-control', 'id' => 'stat3_label']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat4_value', 'قيمة الإحصائية 4') }}
                                    {{ Form::text('stat4_value', $basic['stat4_value'] ?? '+50,000', ['class' => 'form-control', 'id' => 'stat4_value']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('stat4_label', 'وصف الإحصائية 4') }}
                                    {{ Form::text('stat4_label', $basic['stat4_label'] ?? 'مستخدم يستفيدون من خدماتنا', ['class' => 'form-control', 'id' => 'stat4_label']) }}
                                </div>

                                <!-- CTA Section -->
                                <div class="mb-3">
                                    {{ Form::label('cta_title', 'عنوان قسم الدعوة للعمل') }}
                                    {{ Form::text('cta_title', $basic['cta_title'] ?? 'ماذا نقدم في سداد', ['class' => 'form-control', 'id' => 'cta_title']) }}
                                </div>

                                <div class="mb-3">
                                    {{ Form::label('cta_subtitle', 'وصف قسم الدعوة للعمل') }}
                                    {{ Form::text('cta_subtitle', $basic['cta_subtitle'] ?? 'مع سداد نقدم لك حلول دفع مرنة ومريحة تناسب احتياجاتك استخراج قرض العمل الحر وقرض الاسرة والزواج', ['class' => 'form-control', 'id' => 'cta_subtitle']) }}
                                </div>

                                <!-- CTA Items -->
                                <div class="mb-3">
                                    {{ Form::label('cta1_title', 'عنوان عنصر الدعوة 1') }}
                                    {{ Form::text('cta1_title', $basic['cta1_title'] ?? 'تخلص من ايقاف الخدمات', ['class' => 'form-control', 'id' => 'cta1_title']) }}
                                </div>


                                <div class="mb-3">
                                    {{ Form::label('cta2_title', 'عنوان عنصر الدعوة 2') }}
                                    {{ Form::text('cta2_title', $basic['cta2_title'] ?? 'سدد المخالفات المرورية', ['class' => 'form-control', 'id' => 'cta2_title']) }}
                                </div>



                                <div class="mb-3">
                                    {{ Form::label('cta3_title', 'عنوان عنصر الدعوة 3') }}
                                    {{ Form::text('cta3_title', $basic['cta3_title'] ?? 'تخلص من تعثرات سمة واستمتع بسجل ائتماني نظيف', ['class' => 'form-control', 'id' => 'cta3_title']) }}
                                </div>


                                <!-- زر الدعوة إلى الإجراء -->
                                <div class="mb-3">
                                    {{ Form::label('hero_cta', 'زر الدعوة إلى الإجراء (CTA)') }}
                                    {{ Form::text('hero_cta', $basic['hero_cta'] ?? 'تواصل معنا الآن', ['class' => 'form-control', 'id' => 'hero_cta']) }}
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
                                    <img src="{{ asset('storage/'.$basic['slider_image']) }}" alt="Slider Image" class="img-thumbnail mt-2" width="150">
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
