@extends('Liquidity.parent')
@section('title', 'اتصل بنا - سيولتك')
@section('styles')
    <style>
        .contact-section {
            padding: 5rem 0;
            background-color: #f8fafc;
            position: relative;
        }

        .contact-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='84' height='48' viewBox='0 0 84 48' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h12v6H0V0zm28 8h12v6H28V8zm14-8h12v6H42V0zm14 0h12v6H56V0zm0 8h12v6H56V8zM42 8h12v6H42V8zm0 16h12v6H42v-6zm14-8h12v6H56v-6zm14 0h12v6H70v-6zm0-16h12v6H70V0zM28 32h12v6H28v-6zM14 16h12v6H14v-6zM0 24h12v6H0v-6zm0 8h12v6H0v-6zm14 0h12v6H14v-6zm14 8h12v6H28v-6zm-14 0h12v6H14v-6zm28 0h12v6H42v-6zm14-8h12v6H56v-6zm0-8h12v6H56v-6zm14 8h12v6H70v-6zm0 8h12v6H70v-6zM14 24h12v6H14v-6zm14-8h12v6H28v-6zM14 8h12v6H14V8zM0 8h12v6H0V8z' fill='%230047b3' fill-opacity='0.02' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: 0;
        }

        .contact-header {
            position: relative;
            z-index: 1;
            margin-bottom: 3rem;
        }

        .contact-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0047b3;
            margin-bottom: 1rem;
        }

        .contact-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .contact-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0; 
            left: 0;        
            width: 100%;   
            height: 6px;         
            background: linear-gradient(to right, #0047b3, #00a1ff); 
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
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
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0047b3;
            box-shadow: 0 0 0 3px rgba(0, 71, 179, 0.1);
            background-color: #fff;
        }

        .contact-submit-btn {
            background: linear-gradient(to right, #0047b3, #00a1ff);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .contact-submit-btn:hover {
            background: linear-gradient(to right, #003a8c, #0089e0);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 71, 179, 0.15);
        }

        .contact-info {
            background-color: #f1f7ff;
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
        }

        .contact-info-item {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background-color: #0047b3;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1rem;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .contact-text h5 {
            font-weight: 600;
            color: #0047b3;
            margin-bottom: 0.3rem;
        }

        .contact-text p {
            color: #64748b;
            margin-bottom: 0;
        }

        @media (max-width: 992px) {
            .contact-info {
                margin-top: 2rem;
            }
            .contact-section {
                padding: 4rem 0;
            }
            .contact-header {
                margin-bottom: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .contact-title {
                font-size: 2rem;
            }
            
            .contact-card {
                padding: 2rem 1.5rem;
            }
            
            .contact-section {
                padding: 3rem 0;
            }
            
            .contact-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .form-group {
                margin-bottom: 1.2rem;
            }
            
            .contact-submit-btn {
                padding: 0.65rem 1.8rem;
            }
        }
        
        @media (max-width: 576px) {
            .contact-title {
                font-size: 1.75rem;
                margin-bottom: 0.75rem;
            }
            
            .contact-card {
                padding: 1.75rem 1.25rem;
                border-radius: 12px;
            }
            
            .contact-section {
                padding: 2.5rem 0;
            }
            
            .contact-header {
                margin-bottom: 2rem;
            }
            
            .form-control {
                padding: 0.65rem 0.9rem;
                font-size: 0.95rem;
            }
            
            .form-label {
                font-size: 0.95rem;
                margin-bottom: 0.4rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="contact-section">
        <div class="container">
            <div class="contact-header text-center">
                <h2 class="contact-title">تواصل معنا</h2>
                <p class="contact-subtitle">
                    نحن هنا للإجابة على استفساراتك ومساعدتك في كل ما تحتاجه. يمكنك ملء النموذج أدناه وسنقوم بالرد عليك في أقرب وقت ممكن.
                </p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-card">
                        <form action="{{route('contact.send')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">الاسم الكامل</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="أدخل اسمك الكامل" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="example@domain.com" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="موضوع الرسالة">
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="form-label">رسالتك</label>
                                <textarea class="form-control" name="message" id="message" rows="5" placeholder="اكتب رسالتك هنا..." required></textarea>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="contact-submit-btn">
                                    <i class="fas fa-paper-plane me-2"></i> إرسال الرسالة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection