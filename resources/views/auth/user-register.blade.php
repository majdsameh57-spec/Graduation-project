@extends('Liquidity.parent')
@section('title', 'إنشاء حساب مستخدم جديد - سيولتك')
@section('styles')
    <style>
        .register-section {
            padding: 4rem 0;
            min-height: calc(100vh - 150px);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(245, 247, 250, 0.8);
            background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 1500"%3E%3Cdefs%3E%3CradialGradient id="a" gradientUnits="objectBoundingBox"%3E%3Cstop offset="0" stop-color="%23ffffff"%2F%3E%3Cstop offset="1" stop-color="%23f5f7fa"%2F%3E%3C%2FradialGradient%3E%3ClinearGradient id="b" gradientUnits="userSpaceOnUse" x1="0" y1="750" x2="1550" y2="750"%3E%3Cstop offset="0" stop-color="%23f7fbff"%2F%3E%3Cstop offset="1" stop-color="%23f5f7fa"%2F%3E%3C%2FlinearGradient%3E%3C%2Fdefs%3E%3Cpath fill="url(%23a)" d="M1549.2 51.6c-5.4 99.1-20.2 197.6-44.2 293.6c-24.1 96-57.4 189.4-99.3 278.6c-41.9 89.2-92.4 174.1-150.3 253.3c-58 79.2-123.4 152.6-195.1 219c-71.7 66.4-149.6 125.8-232.2 177.2c-82.7 51.4-170.1 94.7-260.7 129.1c-90.6 34.4-184.4 60-279.5 76.3C192.6 1495 96.1 1502 0 1500c96.1-2.1 191.8-13.3 285.4-33.6c93.6-20.2 185-49.5 272.5-87.2c87.6-37.7 171.3-83.8 249.6-137.3c78.4-53.5 151.5-114.5 217.9-181.7c66.5-67.2 126.4-140.7 178.6-218.9c52.3-78.3 96.9-161.4 133-247.9c36.1-86.5 63.8-176.2 82.6-267.6c18.8-91.4 28.6-184.4 29.6-277.4c0.3-27.6 23.2-48.7 50.8-48.4s49.5 21.8 49.2 49.5c0 0.7 0 1.3-0.1 2L1549.2 51.6z"/%3E%3Cg id="g"%3E%3Cpath fill="%23F3F4F6" d="M1549.2 51.6c-5.4 99.1-20.2 197.6-44.2 293.6c-24.1 96-57.4 189.4-99.3 278.6c-41.9 89.2-92.4 174.1-150.3 253.3c-58 79.2-123.4 152.6-195.1 219c-71.7 66.4-149.6 125.8-232.2 177.2c-82.7 51.4-170.1 94.7-260.7 129.1c-90.6 34.4-184.4 60-279.5 76.3C192.6 1495 96.1 1502 0 1500c96.1-2.1 191.8-13.3 285.4-33.6c93.6-20.2 185-49.5 272.5-87.2c87.6-37.7 171.3-83.8 249.6-137.3c78.4-53.5 151.5-114.5 217.9-181.7c66.5-67.2 126.4-140.7 178.6-218.9c52.3-78.3 96.9-161.4 133-247.9c36.1-86.5 63.8-176.2 82.6-267.6c18.8-91.4 28.6-184.4 29.6-277.4c0.3-27.6 23.2-48.7 50.8-48.4s49.5 21.8 49.2 49.5c0 0.7 0 1.3-0.1 2L1549.2 51.6z"/%3E%3C%2Fg%3E%3C%2Fsvg%3E');
            background-size: cover;
        }

        .register-section .container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            max-width: 560px;
            width: 100%;
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, #0047b3, #00a1ff);
        }

        .register-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0047b3;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .register-subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .register-type-tabs {
            display: flex;
            justify-content: center;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }
        
        .register-type-tab {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .register-type-tab:hover {
            color: #334155;
        }
        
        .register-type-tab.active {
            color: #0047b3;
            border-bottom: 2px solid #0047b3;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0047b3;
            box-shadow: 0 0 0 3px rgba(0, 71, 179, 0.1);
            background-color: #fff;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .input-with-icon .form-control {
            padding-right: 2.5rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-md-6 {
            width: 50%;
            padding: 0 10px;
        }

        .register-btn {
            background: linear-gradient(to right, #0047b3, #0062f5);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            background: linear-gradient(to right, #003a8c, #0052cc);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 71, 179, 0.15);
        }

        .register-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.95rem;
        }

        .register-link {
            color: #0047b3;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: #0052cc;
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .register-section {
                padding: 3rem 0;
            }
            .register-card {
                max-width: 500px;
                padding: 2.25rem 1.75rem;
            }
            .register-title {
                font-size: 1.6rem;
                margin-bottom: 1.25rem;
            }
            .col-md-6 {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .register-section {
                padding: 2rem 0;
            }
            .register-card {
                padding: 2rem 1.5rem;
                margin: 0 1rem;
                border-radius: 12px;
            }
            .register-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            .register-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            .form-group {
                margin-bottom: 1.25rem;
            }
            .register-type-tabs {
                margin-bottom: 1.25rem;
            }
            .register-type-tab {
                padding: 0.7rem 1rem;
                font-size: 0.9rem;
            }
            .form-control {
                padding: 0.7rem 0.9rem;
                font-size: 0.95rem;
            }
            .register-btn {
                padding: 0.7rem 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-card">
                <div class="register-type-tabs">
                    <a href="{{ route('merchant.register') }}" class="register-type-tab">تسجيل كتاجر</a>
                    <a href="{{ route('user.register') }}" class="register-type-tab active">تسجيل كمستخدم</a>
                </div>
                <h2 class="register-title">✨ انضم إلينا</h2>
                <p class="register-subtitle">سعداء بانضمامك لمجتمعنا، أنشئ حسابك الآن</p>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('user.register.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <div class="input-with-icon">
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="مثال: أحمد محمد" required value="{{ old('name') }}">
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-with-icon">
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="مثال: user@example.com" required value="{{ old('email') }}">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">العنوان</label>
                        <div class="input-with-icon">
                            <input type="text" name="address" class="form-control" id="address"
                                   placeholder="مثال: غزة، الرمال الغربي" required value="{{ old('address') }}">
                            <div class="input-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <div class="input-with-icon">
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="********" required>
                                    <div class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                <div class="input-with-icon">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           id="password_confirmation" placeholder="********" required>
                                    <div class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="register-btn">
                        <i class="fas fa-user-plus me-2"></i> إنشاء حساب
                    </button>
                    <div class="register-links">
                        <p>لديك حساب بالفعل؟ <a href="{{ route('user.login') }}" class="register-link">سجل دخول</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection