<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>سيولتك - نظام إدارة السيولة المالية</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            :root {
                --primary-color: #0047b3;
                --primary-light: #00a1ff;
                --primary-dark: #003a8c;
                --secondary-color: #f1f7ff;
                --text-dark: #334155;
                --text-light: #64748b;
                --background-light: #f8fafc;
                --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
                --transition: all 0.3s ease;
                --border-radius: 16px;
            }
            
            *, *::before, *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            
            html {
                scroll-behavior: smooth;
            }
            
            body {
                font-family: Figtree, sans-serif;
                line-height: 1.6;
                color: var(--text-dark);
                background-color: var(--background-light);
            }
            
            a {
                color: inherit;
                text-decoration: none;
                transition: var(--transition);
            }
            
            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1.5rem;
            }
            
            .header {
                background-color: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
            }
            
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 0;
                height: 70px;
            }
            
            .logo {
                font-size: 1.8rem;
                font-weight: 800;
                color: var(--primary-color);
                display: flex;
                align-items: center;
            }
            
            .logo i {
                margin-left: 0.5rem;
                font-size: 1.4rem;
            }
            
            .nav-links {
                display: flex;
                gap: 2rem;
            }
            
            .nav-link {
                color: var(--text-dark);
                font-weight: 600;
                position: relative;
                padding: 0.5rem 0;
            }
            
            .nav-link:hover {
                color: var(--primary-color);
            }
            
            .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                background-color: var(--primary-color);
                bottom: 0;
                left: 0;
                transition: var(--transition);
            }
            
            .nav-link:hover::after {
                width: 100%;
            }
            
            .auth-buttons {
                display: flex;
                gap: 1rem;
                align-items: center;
            }
            
            .btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                font-weight: 600;
                text-align: center;
                cursor: pointer;
                transition: var(--transition);
            }
            
            .btn-outline {
                border: 2px solid var(--primary-color);
                color: var(--primary-color);
                background: transparent;
            }
            
            .btn-outline:hover {
                background-color: var(--primary-color);
                color: white;
            }
            
            .btn-primary {
                background: linear-gradient(to right, var(--primary-color), var(--primary-light));
                color: white;
                border: none;
                box-shadow: 0 4px 10px rgba(0, 71, 179, 0.2);
            }
            
            .btn-primary:hover {
                background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0, 71, 179, 0.25);
            }
            
            .hero {
                padding: 10rem 0 6rem;
                position: relative;
                overflow: hidden;
                background-image: linear-gradient(135deg, #f8fafc 0%, #edf2fa 100%);
            }
            
            .hero::before {
                content: '';
                position: absolute;
                width: 400px;
                height: 400px;
                border-radius: 50%;
                background: linear-gradient(135deg, rgba(0, 71, 179, 0.08) 0%, rgba(0, 161, 255, 0.03) 100%);
                top: -200px;
                left: -200px;
                z-index: 0;
            }
            
            .hero::after {
                content: '';
                position: absolute;
                width: 300px;
                height: 300px;
                border-radius: 50%;
                background: linear-gradient(135deg, rgba(0, 71, 179, 0.05) 0%, rgba(0, 161, 255, 0.02) 100%);
                bottom: -150px;
                right: -150px;
                z-index: 0;
            }
            
            .hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                gap: 2rem;
            }
            
            .hero-text {
                flex: 1;
            }
            
            .hero-title {
                font-size: 3rem;
                font-weight: 800;
                color: var(--primary-color);
                line-height: 1.2;
                margin-bottom: 1.5rem;
            }
            
            .hero-title span {
                color: var(--primary-light);
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
                color: var(--text-light);
                margin-bottom: 2rem;
                max-width: 500px;
            }
            
            .hero-image {
                flex: 1;
                position: relative;
            }
            
            .hero-image img {
                width: 100%;
                max-width: 500px;
                border-radius: var(--border-radius);
                box-shadow: var(--card-shadow);
            }
            
            .features {
                padding: 6rem 0;
                background-color: white;
            }
            
            .section-header {
                text-align: center;
                margin-bottom: 4rem;
            }
            
            .section-title {
                font-size: 2.5rem;
                font-weight: 800;
                color: var(--primary-color);
                margin-bottom: 1rem;
                position: relative;
                display: inline-block;
            }
            
            .section-title::after {
                content: '';
                position: absolute;
                width: 80px;
                height: 4px;
                background: linear-gradient(to right, var(--primary-color), var(--primary-light));
                bottom: -0.5rem;
                left: 50%;
                transform: translateX(-50%);
                border-radius: 2px;
            }
            
            .section-subtitle {
                color: var(--text-light);
                font-size: 1.1rem;
                max-width: 600px;
                margin: 0 auto;
            }
            
            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }
            
            .feature-card {
                background-color: white;
                border-radius: var(--border-radius);
                box-shadow: var(--card-shadow);
                padding: 2rem;
                transition: var(--transition);
                position: relative;
                z-index: 1;
                overflow: hidden;
            }
            
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
                border-top-left-radius: var(--border-radius);
                border-bottom-left-radius: var(--border-radius);
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }
            
            .feature-icon {
                width: 60px;
                height: 60px;
                background-color: var(--secondary-color);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: var(--primary-color);
                margin-bottom: 1.5rem;
            }
            
            .feature-title {
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--primary-color);
                margin-bottom: 0.75rem;
            }
            
            .feature-text {
                color: var(--text-light);
                margin-bottom: 1.5rem;
            }
            
            .feature-link {
                display: inline-flex;
                align-items: center;
                color: var(--primary-color);
                font-weight: 600;
            }
            
            .feature-link i {
                margin-right: 0.5rem;
                transition: transform 0.3s ease;
            }
            
            .feature-link:hover i {
                transform: translateX(5px);
            }
            
            .footer {
                background-color: #121d33;
                color: white;
                padding: 4rem 0 2rem;
            }
            
            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 3rem;
                margin-bottom: 3rem;
            }
            
            .footer-logo {
                font-size: 1.8rem;
                font-weight: 800;
                color: white;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
            }
            
            .footer-logo i {
                margin-left: 0.5rem;
                font-size: 1.4rem;
                color: var(--primary-light);
            }
            
            .footer-description {
                color: rgba(255, 255, 255, 0.7);
                margin-bottom: 1.5rem;
            }
            
            .footer-social {
                display: flex;
                gap: 1rem;
            }
            
            .social-icon {
                width: 40px;
                height: 40px;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                transition: var(--transition);
            }
            
            .social-icon:hover {
                background-color: var(--primary-color);
                transform: translateY(-3px);
            }
            
            .footer-title {
                font-size: 1.2rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                color: white;
            }
            
            .footer-links {
                list-style: none;
            }
            
            .footer-link {
                margin-bottom: 0.75rem;
            }
            
            .footer-link a {
                color: rgba(255, 255, 255, 0.7);
                transition: var(--transition);
            }
            
            .footer-link a:hover {
                color: white;
                padding-right: 0.5rem;
            }
            
            .copyright {
                text-align: center;
                padding-top: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.9rem;
            }
            
            @media (max-width: 992px) {
                .hero-content {
                    flex-direction: column-reverse;
                    text-align: center;
                }
                
                .hero-subtitle {
                    margin: 0 auto 2rem;
                }
                
                .section-title {
                    font-size: 2rem;
                }
                
                .nav-links {
                    display: none;
                }
            }
            
            @media (max-width: 768px) {
                .hero {
                    padding: 8rem 0 4rem;
                }
                
                .hero-title {
                    font-size: 2.25rem;
                }
                
                .features {
                    padding: 4rem 0;
                }
                
                .features-grid {
                    grid-template-columns: 1fr;
                }
                
                .footer-content {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }
            }
        </style>
    </head>
    <body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <header class="header">
            <div class="container">
                <nav class="navbar">
                    <a href="/" class="logo">
                        <i class="fas fa-wallet"></i>
                        سيولتك
                    </a>
                    
                    <ul class="nav-links">
                        <li><a href="/" class="nav-link">الرئيسية</a></li>
                        <li><a href="/about" class="nav-link">عن المنصة</a></li>
                        <li><a href="{{ route('contact') }}" class="nav-link">تواصل معنا</a></li>
                    </ul>
                    
                    @if (Route::has('login'))
                        <div class="auth-buttons">
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-primary">لوحة التحكم</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline">تسجيل الدخول</a>
                                
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">منصة <span>سيولتك</span> لإدارة السيولة المالية</h1>
                        <p class="hero-subtitle">
                            الحل الأمثل لإدارة التدفقات النقدية وتحسين السيولة المالية لمشروعك. 
                            نساعدك على تحليل البيانات المالية واتخاذ القرارات الصحيحة.
                        </p>
                        <div class="hero-buttons">
                            <a href="{{ route('register') }}" class="btn btn-primary">ابدأ الآن</a>
                            <a href="/about" class="btn btn-outline" style="margin-right: 1rem">تعرف على المنصة</a>
                        </div>
                    </div>
                    
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1579621970795-87facc2f976d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="سيولتك - إدارة مالية">
                    </div>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">مميزات المنصة</h2>
                    <p class="section-subtitle">نقدم لك مجموعة من المميزات المتكاملة التي تساعدك على إدارة التدفقات النقدية وتحسين أداء مشروعك المالي</p>
                </div>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">تحليل البيانات</h3>
                        <p class="feature-text">
                            أدوات متقدمة لتحليل البيانات المالية وعرضها بطريقة سهلة وواضحة تساعدك على فهم الوضع المالي لمشروعك.
                        </p>
                        <a href="#" class="feature-link">
                            <i class="fas fa-arrow-left"></i>
                            تعرف على المزيد
                        </a>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="feature-title">إدارة السيولة</h3>
                        <p class="feature-text">
                            أدوات متكاملة لإدارة التدفقات النقدية ومراقبة السيولة المالية لمشروعك بشكل مستمر وفعال.
                        </p>
                        <a href="#" class="feature-link">
                            <i class="fas fa-arrow-left"></i>
                            تعرف على المزيد
                        </a>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3 class="feature-title">التقارير المالية</h3>
                        <p class="feature-text">
                            إنشاء تقارير مالية احترافية ومخصصة تساعدك على اتخاذ القرارات المالية الصحيحة لمشروعك.
                        </p>
                        <a href="#" class="feature-link">
                            <i class="fas fa-arrow-left"></i>
                            تعرف على المزيد
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div>
                        <a href="/" class="footer-logo">
                            <i class="fas fa-wallet"></i>
                            سيولتك
                        </a>
                        <p class="footer-description">
                            منصة متكاملة لإدارة السيولة المالية وتحسين الأداء المالي لمشروعك 
                            بأدوات متقدمة وسهلة الاستخدام.
                        </p>
                        <div class="footer-social">
                            <a href="#" class="social-icon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="footer-title">روابط سريعة</h4>
                        <ul class="footer-links">
                            <li class="footer-link">
                                <a href="/">الرئيسية</a>
                            </li>
                            <li class="footer-link">
                                <a href="/about">عن المنصة</a>
                            </li>
                            <li class="footer-link">
                                <a href="{{ route('contact') }}">تواصل معنا</a>
                            </li>
                            <li class="footer-link">
                                <a href="{{ route('register') }}">إنشاء حساب</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="footer-title">المساعدة والدعم</h4>
                        <ul class="footer-links">
                            <li class="footer-link">
                                <a href="#">الأسئلة الشائعة</a>
                            </li>
                            <li class="footer-link">
                                <a href="#">دليل الاستخدام</a>
                            </li>
                            <li class="footer-link">
                                <a href="#">شروط الخدمة</a>
                            </li>
                            <li class="footer-link">
                                <a href="#">سياسة الخصوصية</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="footer-title">تواصل معنا</h4>
                        <ul class="footer-links">
                            <li class="footer-link">
                                <a href="#">
                                    <i class="fas fa-map-marker-alt" style="margin-left: 0.5rem"></i>
                                    غزة، فلسطين
                                </a>
                            </li>
                            <li class="footer-link">
                                <a href="mailto:info@sayoltak.ps">
                                    <i class="fas fa-envelope" style="margin-left: 0.5rem"></i>
                                    info@sayoltak.ps
                                </a>
                            </li>
                            <li class="footer-link">
                                <a href="tel:+97259000000">
                                    <i class="fas fa-phone-alt" style="margin-left: 0.5rem"></i>
                                    +972 59 000 0000
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} سيولتك - جميع الحقوق محفوظة</p>
                </div>
            </div>
        </footer>
    </body>
</html>