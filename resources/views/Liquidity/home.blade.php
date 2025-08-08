@extends('Liquidity.parent')
@section('title', 'سيولتك - منصة إدارة السيولة')
@section('styles')
    <style>
        .hero {
            background: linear-gradient(145deg, #eef5ff 0%, #ffffff 100%);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
ش
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230047b3' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: #0047b3;
            margin-bottom: 0.5rem;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        }

        .hero-subtitle {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #334155;
        }

        .hero-text {
            font-size: 1.15rem;
            color: #475569;
            margin-bottom: 2rem;
            max-width: 550px;
        }

        .hero-buttons .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
        }

        .hero-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .hero-image-wrapper {
            position: relative;
            width: 100%;
            max-width: 550px;
            margin: auto;
            z-index: 1;
        }

        .hero-image {
            width: 100%;
            height: auto;
            border-radius: 20px;
            clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
            box-shadow: 0 20px 40px rgba(0, 71, 179, 0.12);
            transition: transform 0.4s ease-out;
        }

        .hero-image:hover {
            transform: scale(1.03) rotate(1deg);
        }

        .about-section {
            padding: 6rem 0;
            background-color: #f8fafc;
            position: relative;
        }

        .about-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, rgba(0,71,179,0) 0%, rgba(0,71,179,0.3) 50%, rgba(0,71,179,0) 100%);
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 3rem;
            color: #1e293b;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: #0047b3;
            border-radius: 2px;
        }

        .about-image {
            width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #475569;
            margin-bottom: 1.5rem;
        }

        .stores-section {
            padding: 6rem 0;
            background-color: #ffffff;
        }

        .store-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .store-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .store-img-container {
            overflow: hidden;
            width: 100%;
            height: 200px;
        }

        .store-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .store-card:hover img {
            transform: scale(1.05);
        }

        .store-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .store-card h5 {
            font-weight: 700;
            font-size: 1.25rem;
            color: #0047b3;
            margin-bottom: 0.75rem;
        }

        .store-card p {
            color: #64748b;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .store-card .btn {
            align-self: center;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s ease;
        }

        .store-card .btn:hover {
            transform: scale(1.05);
        }

        @media (max-width: 992px) {
            .hero {
                padding: 4rem 0;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.5rem;
            }

            .about-section,
            .stores-section {
                padding: 4rem 0;
            }

            .about-image {
                margin-top: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 3rem 0;
                text-align: center;
            }

            .hero-title {
                font-size: 2.25rem;
            }
            
            .hero-text {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
                display: flex;
            }
            
            .hero-image-wrapper {
                margin-top: 2rem;
                max-width: 100%;
            }
            
            .section-title {
                font-size: 1.75rem;
                margin-bottom: 2rem;
            }

            .about-section,
            .stores-section {
                padding: 3rem 0;
            }

            .store-img-container {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 2rem 0;
            }

            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.25rem;
            }
            
            .hero-text {
                font-size: 1rem;
            }

            .hero-buttons .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .about-text {
                font-size: 1rem;
            }

            .about-section,
            .stores-section {
                padding: 2.5rem 0;
            }

            .store-card h5 {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">سيولتك</h1>
                    <h2 class="hero-subtitle">تسوّق بلا عمولة – اربح أكثر، ادفع أقل</h2>
                    <p class="hero-text">
                        منصة تجارة إلكترونية مبتكرة لربط التجار بالمستهلكين بشكل مباشر، وتمكين الجميع من البيع والشراء بسهولة وبدون أي عمولات، دعمًا للاقتصاد المحلي والتجارة العادلة.
                    </p>
                    @guest
                    <div class="hero-buttons">
                        <a href="{{ route('show-login') }}" class="btn btn-primary me-2">
                            <i class="fas fa-sign-in-alt me-2"></i> تسجيل دخول
                        </a>
                        <a href="{{ route('merchant.register') }}" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i> حساب جديد
                        </a>
                    </div>
                    @endguest
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('assets/img/Bank_of_Palestine_building.2e16d0ba.fill-367x245.jpg') }}"
                            alt="صورة المبنى" class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <h3 class="section-title">من نحن</h3>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <p class="about-text">
                        سيولتك هي منصة تجارة إلكترونية مبتكرة تربط التجار بالمستخدمين مباشرة دون وسطاء أو عمولات، مما يمنح كل طرف تجربة بيع وشراء عادلة وشفافة.
                    </p>
                    <p class="about-text">
                        نهدف إلى دعم الاقتصاد المحلي من خلال توفير مساحة رقمية آمنة وسهلة الاستخدام لعرض المنتجات، والتواصل المباشر بين التاجر والمستهلك، دون أي رسوم إضافية.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-primary me-2">
                            <i class="fas fa-info-circle me-1"></i> قراءة المزيد
                        </a>
                        <a href="{{ route('Liquidity.contact') }}" class="btn btn-outline-success">
                            <i class="fas fa-envelope me-1"></i> اتصل بنا
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/img/s32US.jpg') }}" alt="أموال" class="about-image">
                </div>
            </div>
        </div>
    </section>
    <section id="stores" class="stores-section">
        <div class="container">
            <h3 class="section-title">المحلات المميزة</h3>
            <div class="row g-4">
                @foreach ($shopes as $shop)
                    <div class="col-lg-3 col-md-4 col-sm-6 card-container">
                        <div class="store-card d-flex flex-column p-3" style="background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%); border-radius: 22px; box-shadow: 0 4px 24px rgba(0,0,0,0.09); align-items:center;">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}" style="border-radius:50%; width:170px; height:170px; object-fit:cover; box-shadow:0 4px 16px rgba(0,0,0,0.11); border:6px solid #fff; margin-bottom:22px;">
                               <div class="shop-title" style="text-align:center; font-size:1.25rem; font-weight:bold; color:#0054d7;">
                                <i class="fas fa-store-alt me-2 text-dark"></i>
                                {{ $shop->name }}
                                @if($shop->branches && $shop->branches->count() > 0)
                                    <span class="text-muted fs-6 ms-1">(الفرع الرئيسي)</span>
                                @endif
                            </div>
                            <div class="shop-desc" style="text-align:center;">
                                <span class="badge-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $shop->description }}</span>
                                </span>
                            </div>
                            @if($shop->phone)
                                <div class="shop-contact" style="text-align:center; color:#0054d7; font-size:1rem;">
                                    <i class="bi bi-telephone"></i> {{ $shop->phone }}
                                </div>
                            @endif
                            <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-outline-primary mt-auto">
                                <i class="fas fa-info-circle me-1"></i> عرض التفاصيل
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection