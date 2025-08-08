<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link href="{{ asset('assets/bootstrap-5.3.0-alpha1/dist/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('styles')
    <style>
        .navbar {
            background: linear-gradient(90deg, #0047b3 60%, #00a1ff 100%) !important;
            box-shadow: 0 2px 16px rgba(0, 71, 179, 0.10);
        }
        .nav-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            color: var(--primary-color);
            font-size: 1.25rem;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, border 0.2s;
            box-shadow: 0 2px 8px rgba(0,71,179,0.10);
            margin-left: 3px;
            margin-right: 3px;
            position: relative;
        }
        .nav-icon-btn:hover, .nav-icon-btn:focus {
            background: #f3f7ff;
            color: #00a1ff;
            border: 1.5px solid #00a1ff;
            box-shadow: 0 4px 16px rgba(0,161,255,0.13);
        }
        .nav-icon-btn .badge {
            font-size: 0.8rem;
        }
        .nav-profile-btn {
            background: #fff;
            color: var(--primary-color);
            font-size: 1.08rem;
            border-radius: 22px;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, border 0.2s;
            box-shadow: 0 2px 8px rgba(0,71,179,0.10);
            min-width: 120px;
            font-weight: 700;
            padding: 0.4rem 1.1rem 0.4rem 0.9rem;
        }
        .nav-profile-btn:hover, .nav-profile-btn:focus {
            background: #f3f7ff;
            color: #00a1ff;
            border: 1.5px solid #00a1ff;
            box-shadow: 0 4px 16px rgba(0,161,255,0.13);
        }
        .nav-profile-btn .nav-username {
            color: var(--primary-color);
            font-size: 1.13rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-profile-btn .fa-chevron-down {
            color: var(--primary-color);
            font-size: 0.95rem;
        }
        .nav-profile-btn:active, .nav-icon-btn:active {
            background: #f3f7ff;
        }
        .user-actions {
            gap: 0.85rem !important;
        }
        @media (max-width: 768px) {
            .user-actions {
                gap: 0.5rem !important;
            }
            .nav-profile-btn {
                min-width: 80px;
                font-size: 0.95rem;
            }
        }
        .nav-icon-btn .fa-shopping-cart,
        .nav-icon-btn .fa-bell,
        .nav-profile-btn .fa-chevron-down {
            border-bottom: none !important;
        }
        .navbar-brand {
            font-size: 1.7rem;
            font-weight: 900;
            color: transparent;
            background: none;
            border-radius: 0;
            box-shadow: none;
            padding: 0 0.2rem 0 0.2rem;
            margin-left: 0.2rem;
            margin-bottom: 0.15rem;
            display: flex;
            align-items: flex-end;
            border-bottom: 3px solid #00a1ff;
            letter-spacing: 1.5px;
            text-shadow: 0 3px 12px rgba(0,71,179,0.13), 0 1px 0 #fff;
            height: 2.5rem;
            position: relative;
        }
        .navbar-brand:after {
            content: "";
            position: absolute;
            left: 0; right: 0; bottom: -7px;
            height: 7px;
            border-radius: 0 0 12px 12px;
            background: linear-gradient(90deg, #00a1ff55 0%, #0047b355 100%);
            filter: blur(2px);
            opacity: 0.7;
            z-index: 1;
        }
        .navbar-brand span {
            background: linear-gradient(90deg, #00a1ff 0%, #0047b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            font-weight: 900;
            font-size: 1.7rem;
            padding-right: 0.18rem;
            line-height: 1.1;
            z-index: 2;
            position: relative;
        }
        .navbar-brand i {
            font-size: 1.25em;
            color: #00a1ff;
            filter: drop-shadow(0 1px 3px #00a1ff33);
            margin-left: 0.45rem;
            z-index: 2;
            position: relative;
        }
        .navbar-nav {
            margin-right: 1.2rem;
        }
        .nav-link {
            color: #fff !important;
            font-weight: 600;
            font-size: 1.05rem;
            border-radius: 10px;
            margin: 0 0.18rem;
            transition: background 0.2s, color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(0,161,255,0.13);
            color: #00a1ff !important;
        }
        .dropdown-menu {
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,71,179,0.13);
            border: none;
            padding: 0.5rem 0;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.97rem;
            color: var(--text-color);
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background: rgba(0,161,255,0.10);
            color: #00a1ff;
        }
        .notifications-menu .dropdown-header {
            background: linear-gradient(90deg, #e3f0ff 60%, #f0fbff 100%);
            color: #0047b3;
            font-size: 1.08rem;
            font-weight: 800;
        }
        .notifications-menu .dropdown-divider {
            border-color: #e3f0ff;
        }
        .notifications-menu .text-muted {
            color: #7a8ca3 !important;
        }
        footer {
            background: linear-gradient(90deg, #0047b3 60%, #00a1ff 100%) !important;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,71,179,0.10);
        }
        :root {
            --primary-color: #0047b3;
            --secondary-color: #f8f9fa;
            --accent-color: #00a1ff;
            --text-color: #333;
            --light-color: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
            background: var(--primary-color) !important;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--light-color) !important;
        }
        .nav-link {
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            margin: 0 0.25rem;
            transition: var(--transition);
        }
        .nav-link:hover, 
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--light-color) !important;
        }
        .section-container {
            padding: 3rem 1.5rem;
        }
        .custom-card {
            background: var(--light-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
            border: none;
        }
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #003d99;
            border-color: #003d99;
        }
        .btn-success {
            background-color: #0fa36b;
            border-color: #0fa36b;
        }
        .btn-success:hover {
            background-color: #0c8456;
            border-color: #0c8456;
        }
        .form-control, .form-select {
            padding: 0.7rem 1rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            transition: var(--transition);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 71, 179, 0.15);
        }
        footer {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 4rem;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .navbar-nav {
                padding-top: 0.5rem;
            }
            .nav-link {
                text-align: center;
            }
            .section-container {
                padding: 2rem 1rem;
            }
            .navbar-brand span {
                font-size: 1.4rem;
            }
            .navbar-brand i {
                font-size: 1.1em;
            }
            .user-actions {
                flex-wrap: wrap;
                justify-content: center;
            }
            .dropdown-menu.notifications-menu {
                width: 280px !important;
            }
            .custom-card {
                margin-bottom: 1.5rem;
            }
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            .navbar-brand span {
                font-size: 1.2rem;
            }
            .section-container {
                padding: 1.5rem 0.75rem;
            }
            .notifications-menu .dropdown-header {
                font-size: 1rem;
            }
            .dropdown-menu.notifications-menu {
                width: 250px !important;
                max-height: 350px;
            }
        }
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem 0;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: var(--text-color);
            transition: all 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: rgba(0, 71, 179, 0.08);
            color: var(--primary-color);
        }
        .dropdown-divider {
            margin: 0.25rem 0;
            border-color: #f1f5f9;
        }
        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        .notification-item:hover {
            background-color: #f8fafc;
        }
        .notification-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-color);
        }
        .notification-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }
        .notification-time {
            font-size: 0.75rem;
            color: #94a3b8;
        }
        .notification-unread {
            background-color: rgba(0, 71, 179, 0.05);
        }
        .notification-unread .notification-title {
            color: var(--primary-color);
        }
        .user-profile-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            font-size: 0.9rem;
        }
        .text-primary {
            color: var(--primary-color) !important;
        }
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        .shadow-sm {
            box-shadow: var(--box-shadow) !important;
        }
        .swal2-popup {
            font-family: 'Cairo', sans-serif;
            border-radius: var(--border-radius);
        }
        @auth('web')
        .mobile-top-bar {
            display: flex !important;
        }
        @endauth
        @media (max-width: 576px) {
            .mobile-top-bar {
                display: flex !important;
            }
            .nav-icon-btn {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                font-size: 1.15rem;
                background: transparent !important;
                box-shadow: none !important;
                position: relative;
                justify-content: center;
                align-items: center;
                display: flex;
            }
            .nav-icon-btn .badge {
                font-size: 0.7rem;
                top: 2px !important;
                right: 2px !important;
            }
        }
        @media (min-width: 577px) {
            .mobile-top-bar {
                display: none !important;
            }
        }
        html, body {
            height: 100%;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('Liquidity.home') }}">
                <i class="fas fa-money-bill-wave me-2"></i><span>سيولتك</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Liquidity.home') ? 'active' : '' }}"
                            href="{{ route('Liquidity.home') }}">
                            <i class="fas fa-home me-1"></i> الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('all.shops') ? 'active' : '' }}"
                        href="{{ route('all.shops') }}">
                            <i class="fas fa-store me-1"></i> عرض المحلات
                        </a>
                    </li>
                    @php
                    use Illuminate\Support\Str;
                    @endphp

                    @guest('web')
                    <li class="nav-item">
                        <a class="nav-link {{ 
                            Str::startsWith(request()->route()->getName(), 'merchant.') || 
                            request()->routeIs('show-login') || 
                            request()->routeIs('user.login') || 
                            request()->routeIs('user.register') || 
                            request()->routeIs('password.*') || 
                            request()->routeIs('merchant.register') ? 'active' : '' 
                        }}" href="{{ route('show-login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> تسجيل الدخول
                        </a>
                    </li>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Liquidity.load-data') ? 'active' : '' }}"
                            href="{{ route('Liquidity.load-data') }}">
                            <i class="fas fa-file-upload me-1"></i> تحميل بيانات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Liquidity.contact') ? 'active' : '' }}"
                            href="{{ route('Liquidity.contact') }}">
                            <i class="fas fa-envelope me-1"></i> اتصل بنا
                        </a>
                    </li>
                </ul>
                
                @auth('web')
                <div class="ms-auto d-flex align-items-center">
                    <div class="user-actions d-none d-lg-flex align-items-center gap-2">
                        <a href="{{ route('cart.show') }}" class="cart-btn nav-icon-btn position-relative d-flex align-items-center justify-content-center" id="cartDropdown">
                            <i class="fas fa-shopping-cart" ></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" id="cart-badge">0</span>
                        </a>
                        <div class="dropdown">
                            <a href="#" class="notif-btn nav-icon-btn position-relative d-flex align-items-center justify-content-center" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge">0</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end notifications-menu p-0" aria-labelledby="notificationsDropdown" style="width: 320px; max-height: 420px; overflow-y: auto;  box-shadow: 0 8px 32px rgba(0,71,179,0.10);">
                                <li>
                                    <h6 class="dropdown-header py-3 text-primary fw-bold bg-light mb-0" >الإشعارات</h6>
                                </li>
                                <ul id="notifications-container" class="list-unstyled m-0 p-0">
                                    <li class="text-center p-3 text-muted">لا توجد إشعارات جديدة</li>
                                </ul>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item text-center py-2" href="#" style="color: var(--primary-color); font-weight: 600;">عرض جميع الإشعارات</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="profile-btn d-flex align-items-center gap-2 px-2 py-1 nav-profile-btn" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <span class="fw-bold d-none d-md-inline nav-username" style="padding-bottom: 2px;">{{ Auth::guard('web')->user()->name }}</span>
                                <i class="fas fa-chevron-down text-primary ms-1" ></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small user-menu" aria-labelledby="userDropdown" style=" box-shadow: 0 8px 32px rgba(0,71,179,0.10);">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('user.profile') }}">
                                        <i class="fas fa-user-circle text-primary"></i>
                                        <span>الملف الشخصي</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="{{ route('user.logout') }}">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>تسجيل الخروج</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    @auth('web')
    <div class="mobile-top-bar d-flex d-lg-none justify-content-center align-items-center py-2" style="background: linear-gradient(90deg, #0047b3 60%, #00a1ff 100%);">
        <a href="{{ route('cart.show') }}" class="cart-btn nav-icon-btn position-relative mx-2" style="color:#fff;">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" id="cart-badge">0</span>
        </a>
        <div class="dropdown">
            <a href="#" class="notif-btn nav-icon-btn position-relative mx-2" id="mobileNotificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color:#fff;">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge">0</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end notifications-menu p-0" aria-labelledby="mobileNotificationsDropdown" style="width: 250px; max-height: 350px; overflow-y: auto; box-shadow: 0 8px 32px rgba(0,71,179,0.10);">
                <li>
                    <h6 class="dropdown-header py-3 text-primary fw-bold bg-light mb-0">الإشعارات</h6>
                </li>
                <ul id="notifications-container-mobile" class="list-unstyled m-0 p-0">
                    <li class="text-center p-3 text-muted">لا توجد إشعارات جديدة</li>
                </ul>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item text-center py-2" href="#" style="color: var(--primary-color); font-weight: 600;">عرض جميع الإشعارات</a>
                </li>
            </ul>
        </div>
        <a href="{{ route('user.profile') }}" class="profile-btn nav-icon-btn mx-2" style="color:#fff;">
            <i class="fas fa-user"></i>
        </a>
    </div>
    @endauth
    <main>
        @yield('content')
    </main>
    <div style="height: 80px;"></div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-0">
                        <i class="far fa-copyright me-1"></i> 2025 سيولتك - جميع الحقوق محفوظة
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <style>
        html, body {
            height: 100%;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
    @yield('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/bootstrap-5.3.0-alpha1/dist/js/bootstrap.bundle.min.js') }}"></script>
    @auth('web')
    <script src="{{ asset('assets/js/user-notifications.js') }}"></script>
    <script>
    function updateCartBadge() {
        var cart = JSON.parse(localStorage.getItem('cart') || '[]');
        var count = cart.reduce((sum, p) => sum + (p.quantity || 1), 0);
        document.getElementById('cart-badge').textContent = count;
    }
    document.addEventListener('DOMContentLoaded', updateCartBadge);
    window.addEventListener('storage', updateCartBadge);
    </script>
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            bsCustomFileInput.init();
        });
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        const status = @json(session('status'));
        const icon = @json(session('icon'));
        const message = @json(session('message'));
        if (status) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }
        @if ($errors->any())
            let errorMessages = {!! json_encode($errors->all()) !!};
            Toast.fire({
                icon: 'error',
                html: errorMessages.join('<br>')
            });
        @endif
        function renderNotifications(notifications) {
            let html = '';
            if (!notifications || notifications.length === 0) {
                html = '<li class="text-center p-3 text-muted">لا توجد إشعارات جديدة</li>';
            } else {
                notifications.forEach(function(n) {
                    html += `<li class="notification-item">${n.text}</li>`;
                });
            }
            var desktopList = document.getElementById('notifications-container');
            if (desktopList) desktopList.innerHTML = html;
            var mobileList = document.getElementById('notifications-container-mobile');
            if (mobileList) mobileList.innerHTML = html;
        }
    </script>
</body>

</html>