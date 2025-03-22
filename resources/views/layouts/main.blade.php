<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($settings))
        <title>@yield('title', $settings->title)</title>
        <meta name="description" content="{{ $settings->description }}">
        @if($settings->favicon)
            <link rel="icon" href="{{ asset($settings->favicon) }}" type="image/x-icon">
            <link rel="shortcut icon" href="{{ asset($settings->favicon) }}" type="image/x-icon">
        @endif
    @else
        <title>@yield('title', 'الأمانة للاستيراد والتصدير')</title>
    @endif
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Dynamic CSS -->
    <link rel="stylesheet" href="{{ route('dynamic.css') }}?v={{ time() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('extra_css')
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-content">
            <div class="preloader-logo">
                @if(isset($settings) && $settings->logo)
                    <img src="{{ asset($settings->logo) }}" alt="{{ $settings->title }}" class="preloader-svg">
                @else
                    <img src="{{ asset('images/loader/alamana-preloader-static.svg') }}" alt="الأمانة" class="preloader-svg">
                @endif
            </div>
            <div class="preloader-text">
                <h2>مرحبا بكم في الأمانه</h2>
                <h4>للاستيراد والتصدير</h4>
            </div>
            <div class="preloader-progress">
                <div class="preloader-progress-bar"></div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('extra_js')
</body>
</html> 