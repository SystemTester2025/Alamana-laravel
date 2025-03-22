@extends('layouts.main')

@section('title', $settings->title ?? 'الأمانة للاستيراد والتصدير')

@section('content')
<div class="site-wrapper">
    <div class="hero-section">
        <div class="overlay"></div>
        <img src="{{ asset('images/hero-section/background.jpg') }}" alt="Background" class="hero-background">
            
        <!-- Logo with curved background -->
        <div class="logo-container">
            <div class="logo-curved-bg"></div>
            <div class="top-right-logo">
                @if(isset($settings) && $settings->logo)
                    <img src="{{ asset($settings->logo) }}" alt="{{ $settings->title }}" class="logo">
                @else
                    <img src="{{ asset('images/logo/logo.svg') }}" alt="الأمانة" class="logo">
                @endif
            </div>
        </div>
            
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <div class="navbar-container">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">الرئيسية</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#company">الشركة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#management">الإدارة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#products">المنتجات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">اتصل بنا</a>
                            </li>
                        </ul>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="container hero-content">
            <div class="row">
                <div class="col-12 text-center">
                    @if(isset($sectionsKeyed['hero-section']))
                        <h1 class="main-heading">{{ $sectionsKeyed['hero-section']->title }}</h1>
                        <h1 class="sub-heading">{{ $sectionsKeyed['hero-section']->sub }}</h1>
                    @else
                        <h1 class="main-heading">نحن جسر بين الطبيعة</h1>
                        <h1 class="sub-heading">والأسواق العالمية</h1>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Counter -->
        <div class="product-counter">
            <div class="counter-text">+{{ count($products) }}</div>
            <div class="counter-subtext">منتجات</div>
            <div class="product-dots">
                <span class="dot dot-red"></span>
                <span class="dot dot-white"></span>
                <span class="dot dot-brown"></span>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="scroll-down">
            <a href="#content">
                <div class="scroll-circle">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <span class="scroll-text">اكتشف المزيد</span>
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <section id="content" class="features-section py-5">
        <div class="container">
            @if(isset($sectionsKeyed['features']))
                <h2 class="section-title text-center mb-5">{{ $sectionsKeyed['features']->title }}</h2>
                <h3 class="section-subtitle text-center mb-4">{{ $sectionsKeyed['features']->sub }}</h3>
            @endif
            <div class="row features-row">
                @if(isset($sectionsKeyed['features-section']) && $sectionsKeyed['features-section']->sectionParts->count() > 0)
                    @foreach($sectionsKeyed['features-section']->sectionParts as $feature)
                        <div class="col-md-4 feature-item text-center">
                            <div class="feature-icon-container">
                                @if($feature->image)
                                    <img src="{{ asset($feature->image) }}" alt="{{ $feature->title }}" class="feature-icon">
                                @else
                                    <img src="{{ asset('images/features/features-' . $feature->key . '.svg') }}" alt="{{ $feature->title }}" class="feature-icon">
                                @endif
                            </div>
                            <h2 class="feature-title">{{ $feature->title }}</h2>
                            <p class="feature-description">
                                {!! nl2br(e($feature->desc)) !!}
                            </p>
                        </div>
                    @endforeach
                @else
                    <!-- Feature 1 -->
                    <div class="col-md-4 feature-item text-center">
                        <div class="feature-icon-container">
                            <img src="{{ asset('images/features/features-network.svg') }}" alt="شبكة واسعة" class="feature-icon">
                        </div>
                        <h2 class="feature-title">شبكة واسعة</h2>
                        <p class="feature-description">
                            نتعاون مع أفضل الموردين في جميع<br>
                            أنحاء العالم
                        </p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="col-md-4 feature-item text-center">
                        <div class="feature-icon-container">
                            <img src="{{ asset('images/features/features-quality.svg') }}" alt="جودة عالية" class="feature-icon">
                        </div>
                        <h2 class="feature-title">جودة عالية</h2>
                        <p class="feature-description">
                            نقدم لك منتجات طازجة وفاخرة<br>
                            بأعلى معايير الجودة
                        </p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="col-md-4 feature-item text-center">
                        <div class="feature-icon-container">
                            <img src="{{ asset('images/features/features-service.svg') }}" alt="خدمة متميزة" class="feature-icon">
                        </div>
                        <h2 class="feature-title">خدمة متميزة</h2>
                        <p class="feature-description">
                            نحرص على توفير خدمة عملاء مميزة،<br>
                            وتقديم حلول مرنة تناسب احتياجاتك
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Company Section -->
    <section id="company" class="company-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <div class="benefits-card">
                        @if(isset($sectionsKeyed['company-section']) && $sectionsKeyed['company-section']->sectionParts->where('key', 'company_benefits')->first())
                            <h3 class="benefits-title">{{ $sectionsKeyed['company-section']->sectionParts->where('key', 'company_benefits')->first()->title }}</h3>
                            <p class="benefits-description">
                                {{ $sectionsKeyed['company-section']->sectionParts->where('key', 'company_benefits')->first()->desc }}
                            </p>
                        @else
                            <h3 class="benefits-title">ما الفوائد التي ستحصل عليها عند التعاون معنا</h3>
                            <p class="benefits-description">
                                نتميز بخبرة طويلة في مجال استيراد
                                وتصدير المنتجات الزراعية الجافة نعمل
                                على توفير مجموعة من المنتجات عالية
                                الجودة التي تلبي احتياجات السوق
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="company-card">
                        <img src="{{ asset('images/firm-section/firm-bg.jpeg') }}" alt="خلفية الشركة" class="company-background">
                        <div class="company-leaf-icon">
                            <img src="{{ asset('images/leafs/leaf-company.svg') }}" alt="أيقونة ورق" class="leaf-icon">
                        </div>
                        @if(isset($sectionsKeyed['company-section']))
                            <h2 class="company-title">{{ $sectionsKeyed['company-section']->title }}</h2>
                            <p class="company-description">
                                {{ $sectionsKeyed['company-section']->desc }}
                            </p>
                        @else
                            <h2 class="company-title">الشركة</h2>
                            <p class="company-description">
                                تأسست شركة الأمانة للاستيراد و التصدير عام ٢٠١٢ لتعمل في مجال استيراد و تصدير الحاصلات
                                الزراعية الجافة لذلك فهي أصبحت تمتلك اقوي فريق عمل يتقي المحاصيل ذات الجودة العالية و
                                فرزها و تنقيتها تصديرها لكل بلدان العالم مثل العراق و رومانيا و تركيا و اسبانيا ..... الخ و لسعي
                                الشركة للتوسعات في هذا المجال
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Management Section -->
    <section id="management" class="management-section py-5">
        <div class="container">
            @if(isset($sectionsKeyed['management-section']))
                <h2 class="section-title text-center mb-5">{{ $sectionsKeyed['management-section']->title }}</h2>
                {{-- @if($sectionsKeyed['management-section']->sub)
                    <h3 class="section-subtitle text-center mb-4">{{ $sectionsKeyed['management-section']->sub }}</h3>
                @endif --}}
            @endif
            <div class="row">
                <div class="col-lg-4 order-lg-2">
                    <div class="management-image-card">
                        <div class="image-border">
                            <img src="{{ asset('images/products/amana-product.jpeg') }}" alt="منتجات الأمانة" class="management-image">
                            <div class="image-overlay">
                                <p class="image-text">نحرص على تقديم<br>أسعار مناسبة تناسب<br>جميع أنواع الأسواق</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 order-lg-1">
                    <div class="management-content">
                        <!-- Management Accordion -->
                        <div class="accordion" id="managementAccordion">
                            <!-- إدارة الشركة -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCompany">
                                    <button class="section-heading-container" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">
                                        <span class="section-heading">إدارة الشركة</span>
                                        <div class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="#ffffff">
                                                <path d="M5,13h11.86l-3.63,4.36a1,1,0,0,0,1.54,1.28l5-6a1.19,1.19,0,0,0,.09-.15.127.127,0,0,1,.07-.13.961.961,0,0,0,0-.72.127.127,0,0,0-.07-.13,1.19,1.19,0,0,0-.09-.15l-5-6A1,1,0,0,0,13.23,7a1,1,0,0,0,.13,1.36L16.86,13H5a1,1,0,0,0,0,2Z" transform="rotate(225 12 12)" />
                                            </svg>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseCompany" class="accordion-collapse collapse" aria-labelledby="headingCompany" data-bs-parent="#managementAccordion">
                                    <div class="accordion-body">
                                        <p class="management-description">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_company')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_company')->first()->desc }}
                                            @else
                                                في شركة الأمانة، يقودنا فريق إداري متميز ذو خبرة طويلة في صناعة الاستيراد والتصدير، حيث
                                                نؤمن أن القيادة الحكيمة والتخطيط الاستراتيجي هما أساس نجاحنا المستمر. يتمتع كل عضو في
                                                فريق الإدارة بمعرفة واسعة بمتطلبات السوق الزراعي، مما يعزز قدرتنا على تقديم حلول مبتكرة
                                                تلبي احتياجات عملائنا
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- المدير العام -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingManager">
                                    <button class="section-heading-container" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManager" aria-expanded="true" aria-controls="collapseManager">
                                        <span class="section-heading">المدير العام</span>
                                        <div class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="#ffffff">
                                                <path d="M5,13h11.86l-3.63,4.36a1,1,0,0,0,1.54,1.28l5-6a1.19,1.19,0,0,0,.09-.15.127.127,0,0,1,.07-.13.961.961,0,0,0,0-.72.127.127,0,0,0-.07-.13,1.19,1.19,0,0,0-.09-.15l-5-6A1,1,0,0,0,13.23,7a1,1,0,0,0,.13,1.36L16.86,13H5a1,1,0,0,0,0,2Z" transform="rotate(225 12 12)" />
                                            </svg>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseManager" class="accordion-collapse collapse show" aria-labelledby="headingManager" data-bs-parent="#managementAccordion">
                                    <div class="accordion-body">
                                        <p class="management-description">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_general')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_general')->first()->desc }}
                                            @else
                                                بخبرة تمتد لأكثر من 12 سنوات في مجال التجارة الدولية والقطاع الزراعي، يتولى [اسم المدير العام] قيادة [اسم الشركة] برؤية استراتيجية تهدف إلى النمو المستدام والتوسع في الأسواق العالمية. من خلال مهاراته القيادية، ساهم في تعزيز علاقات الشركة مع شركائها والعملاء في مختلف أنحاء العالم
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- فريق العمل -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTeam">
                                    <button class="section-heading-container" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTeam" aria-expanded="false" aria-controls="collapseTeam">
                                        <span class="section-heading">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_team')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_team')->first()->title }}
                                            @else
                                                فريق العمل
                                            @endif
                                        </span>
                                        <div class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="#ffffff">
                                                <path d="M5,13h11.86l-3.63,4.36a1,1,0,0,0,1.54,1.28l5-6a1.19,1.19,0,0,0,.09-.15.127.127,0,0,1,.07-.13.961.961,0,0,0,0-.72.127.127,0,0,0-.07-.13,1.19,1.19,0,0,0-.09-.15l-5-6A1,1,0,0,0,13.23,7a1,1,0,0,0,.13,1.36L16.86,13H5a1,1,0,0,0,0,2Z" transform="rotate(225 12 12)" />
                                            </svg>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseTeam" class="accordion-collapse collapse" aria-labelledby="headingTeam" data-bs-parent="#managementAccordion">
                                    <div class="accordion-body">
                                        <p class="management-description">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_team')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_team')->first()->desc }}
                                            @else
                                                يضم فريق إدارة شركة الأمانة مجموعة من المتخصصين في مجالات متعددة، مثل الاستيراد التصدير، اللوجستيات والتسويق. يعمل الفريق بتنسيق تام لضمان تقديم أفضل تجربة لعملائنا ويحرص على تنفيذ استراتيجيات مبتكرة تعزز من فعالية العمل في كل جانب من جوانب العملية التجارية
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- قيمنا -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingValues">
                                    <button class="section-heading-container" type="button" data-bs-toggle="collapse" data-bs-target="#collapseValues" aria-expanded="false" aria-controls="collapseValues">
                                        <span class="section-heading">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_values')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_values')->first()->title }}
                                            @else
                                                قيمنا
                                            @endif
                                        </span>
                                        <div class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="#ffffff">
                                                <path d="M5,13h11.86l-3.63,4.36a1,1,0,0,0,1.54,1.28l5-6a1.19,1.19,0,0,0,.09-.15.127.127,0,0,1,.07-.13.961.961,0,0,0,0-.72.127.127,0,0,0-.07-.13,1.19,1.19,0,0,0-.09-.15l-5-6A1,1,0,0,0,13.23,7a1,1,0,0,0,.13,1.36L16.86,13H5a1,1,0,0,0,0,2Z" transform="rotate(225 12 12)" />
                                            </svg>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseValues" class="accordion-collapse collapse" aria-labelledby="headingValues" data-bs-parent="#managementAccordion">
                                    <div class="accordion-body">
                                        <p class="management-description">
                                            @if(isset($sectionsKeyed['management-section']) && $sectionsKeyed['management-section']->sectionParts->where('key', 'management_values')->first())
                                                {{ $sectionsKeyed['management-section']->sectionParts->where('key', 'management_values')->first()->desc }}
                                            @else
                                                <span>الابتكار: نسعى دائمًا لتقديم حلول جديدة ومبتكرة لتحسين عملياتنا التجارية</span>
                                                <span>الاحترافية: التزامنا بمعايير الجودة والتميز في كل خطوة</span>
                                                <span>الشفافية: نؤمن بالتعامل بشفافية مع عملائنا وشركائنا، لضمان أفضل نتائج ممكنة</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Products Section -->
<section class="products-section py-5" id="products">
    <div class="container">
        @if(isset($sectionsKeyed['products-section']))
            <h2 class="section-title">{{ $sectionsKeyed['products-section']->title }}</h2>
            {{-- @if($sectionsKeyed['products-section']->sub)
                <h3 class="section-subtitle text-center mb-4">{{ $sectionsKeyed['products-section']->sub }}</h3>
            @endif
            @if($sectionsKeyed['products-section']->desc)
                <p class="section-description text-center mb-5">{{ $sectionsKeyed['products-section']->desc }}</p>
            @endif --}}
        @else
            <h2 class="section-title">المنتجات</h2>
        @endif
        <div class="products-container row">
            @forelse($products as $product)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="product-image">
                            <div class="product-hover">
                                <div class="product-hover-content">
                                    <h4>{{ $product->title }}</h4>
                                    <p>{{ $product->sub_title }}</p>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset('images/products/amana-product.jpeg') }}" alt="{{ $product->title }}" class="product-image">
                            <div class="product-hover">
                                <div class="product-hover-content">
                                    <h4>{{ $product->title }}</h4>
                                    <p>{{ $product->sub_title }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="product-label">{{ $product->title }}</div>
                    </div>
                </div>
            @empty
                <!-- Fallback static products if no dynamic products are available -->
                <!-- Product 1: Lentils -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/products/amana-product.jpeg') }}" alt="عدس" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>عدس</h4>
                                <p>عدس مصري فاخر</p>
                            </div>
                        </div>
                        <div class="product-label">عدس</div>
                    </div>
                </div>
                
                <!-- Product 2: White Beans -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/firm-section/firm-bg.jpeg') }}" alt="فصوليا بيضاء" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>فصوليا بيضاء</h4>
                                <p>فصوليا بيضاء خالية من الشوائب</p>
                            </div>
                        </div>
                        <div class="product-label">فصوليا بيضاء</div>
                    </div>
                </div>
                
                <!-- Product 3: Chickpeas -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/firm-section/firm-bg.jpeg') }}" alt="حمص" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>حمص</h4>
                                <p>حمص مصري فاخر</p>
                            </div>
                        </div>
                        <div class="product-label">حمص</div>
                    </div>
                </div>
                
                <!-- Product 4: Chickpeas -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/products/trms.jpg') }}" alt="حمص" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>ترمس</h4>
                                <p>ترمس مصري فاخر</p>
                            </div>
                        </div>
                        <div class="product-label">حمص</div>
                    </div>
                </div>
                
                <!-- Product 5: Popcorn -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/products/dora.jpg') }}" alt="ذرة فشار" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>ذرة فشار</h4>
                                <p>ذرة فشار عالية الجودة</p>
                            </div>
                        </div>
                        <div class="product-label">ذرة فشار</div>
                    </div>
                </div>
                
                <!-- Product 6: Fava Beans -->
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="product-item">
                        <img src="{{ asset('images/products/fol.jpg') }}" alt="فول" class="product-image">
                        <div class="product-hover">
                            <div class="product-hover-content">
                                <h4>فول</h4>
                                <p>فول مصري فاخر</p>
                            </div>
                        </div>
                        <div class="product-label">فول</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    
    <style>
        .product-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .product-item:hover {
            transform: translateY(-5px);
        }
        
        .product-hover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .product-item:hover .product-hover {
            opacity: 1;
        }
        
        .product-hover-content {
            text-align: center;
            color: white;
            padding: 20px;
        }
        
        .product-hover-content h4 {
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</section>

<!-- Contact Section -->
<section class="contact-section container" id="contact">
    <img src="{{ asset('images/footer/footer.jpg') }}" alt="Footer background" class="contact-background">
    <div class="contact-header">
        @if(isset($settings) && $settings->footer_logo)
            <img src="{{ asset($settings->footer_logo) }}" alt="{{ $settings->title }}" class="contact-logo">
        @else
            <img src="{{ asset('images/logo/logo.svg') }}" alt="الأمانة" class="contact-logo">
        @endif
    </div>
    <div class="contact-container container">
        <div class="contact-content row">
            <div class="contact-info col-lg-9 order-lg-1">
                <h2 class="contact-title">
                    @if(isset($sectionsKeyed['contact-section']) && $sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_address')->first())
                        {{ $sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_address')->first()->title }}
                    @else
                        العنوان
                    @endif
                </h2>
                <div class="contact-address">
                    @if(isset($sectionsKeyed['contact-section']) && $sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_address')->first())
                        {!! ($sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_address')->first()->desc) !!}
                    @else
                        <p>طريق السادات كفرداود عند مشارق التحرير</p>
                        <p>بجوار الكلية الجديدة/المنوفية/مصر</p>
                    @endif
                </div>
                <h2 class="contact-title">تليفون+واتس اب</h2>
                <div class="contact-phones">
                    @if (isset($sectionsKeyed['contact-section']) && $sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_phones')->first())
                        {!! ($sectionsKeyed['contact-section']->sectionParts->where('key', 'contact_phones')->first()->desc) !!}
                    @else
                        <div class="phone-column">
                        <div class="phone-number">01003103589</div>
                        <div class="phone-number">01024113153</div>
                    </div>
                    <div class="phone-column">
                        <div class="phone-number">01009594480</div>
                        <div class="phone-number">01093809980</div>
                        <div class="phone-number">01000766218</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="contact-map col-lg-3 order-lg-2">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6913.681934278306!2d30.9359!3d30.0759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2seg!4v1645568556012!5m2!1sen!2seg" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Product Lightbox -->
<div class="product-lightbox">
    <div class="lightbox-content">
        <img src="" alt="" class="lightbox-image">
        <div class="lightbox-title"></div>
    </div>
    <div class="lightbox-close"></div>
</div>
@endsection 