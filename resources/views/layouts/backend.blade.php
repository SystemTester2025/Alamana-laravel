<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - لوحة التحكم</title>
    
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Backend CSS -->
    <link rel="stylesheet" href="{{ asset('css/backend/backend.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4 py-3">
            <h3>لوحة التحكم</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> الرئيسية
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sections.index') }}" class="nav-link {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group me-2"></i> الأقسام
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('section-parts.index') }}" class="nav-link {{ request()->routeIs('section-parts.*') ? 'active' : '' }}">
                    <i class="fas fa-puzzle-piece me-2"></i> محتوى الأقسام
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-box me-2"></i> المنتجات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('images.index') }}" class="nav-link {{ request()->routeIs('images.*') ? 'active' : '' }}">
                    <i class="fas fa-images me-2"></i> الصور
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contacts.index') }}" class="nav-link {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope me-2"></i> رسائل التواصل
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i> الإعدادات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backup.index') }}" class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                    <i class="fas fa-database me-2"></i> النسخ الاحتياطي
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                    <i class="fas fa-history me-2"></i> سجل النشاطات
                </a>
            </li>
            <li class="nav-item mt-4 mb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
                    </button>
                </form>
            </li>
        </ul>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Main Content -->
    <div class="content" id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg mb-4">
            <div class="container-fluid">
                <button class="d-md-none btn btn-link" id="showSidebar">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fas fa-user me-2"></i> {{ auth()->user()->name }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
            
            <!-- Footer -->
            <footer class="mt-5 pt-4 border-top">
                <div class="d-flex justify-content-between align-items-center py-3">
                    <div class="footer-logo">
                        <a href="mailto:ahmedrmohamed2017@gmail.com">
                            <img src="{{ asset('images/developer/elnakieb-logo.jpg') }}" alt="Elnakieb Logo" height="30">
                        </a>
                    </div>
                    <div class="footer-text text-muted">
                        <small>تصميم وتطوير بواسطة <span class="fw-bold"><a href="mailto:ahmedrmohamed2017@gmail.com" target="_blank">النقيب</a></span> &copy; {{ date('Y') }}</small>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Sidebar Toggle Button (mobile only) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Responsive Sidebar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const showSidebar = document.getElementById('showSidebar');
            
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            }
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', toggleSidebar);
            
            // Toggle sidebar from navbar button
            if (showSidebar) {
                showSidebar.addEventListener('click', toggleSidebar);
            }
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar on window resize if it becomes desktop view
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
            
            // Close sidebar when clicking on a link (mobile only)
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(function() {
                            sidebar.classList.remove('active');
                            sidebarOverlay.classList.remove('active');
                        }, 100);
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 