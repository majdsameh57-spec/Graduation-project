@extends('Liquidity.parent')
@section('title', 'تحميل البيانات | سيولتك')
@section('styles')
    <style>
        .loading-data-section {
            padding: 6rem 0;
            background-color: #f8fafc;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .loading-data-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(0, 71, 179, 0.08) 0%, rgba(0, 161, 255, 0.03) 100%);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            z-index: 0;
        }

        .loading-data-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(0, 71, 179, 0.05) 0%, rgba(0, 161, 255, 0.02) 100%);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            z-index: 0;
        }

        .loading-data-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            padding: 3rem;
            position: relative;
            z-index: 1;
            text-align: center;
            transition: all 0.3s ease;
        }

        .loading-data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .loading-data-icon {
            font-size: 4rem;
            color: #0047b3;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .loading-data-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0047b3;
            margin-bottom: 1rem;
        }

        .loading-data-description {
            color: #64748b;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .download-btn {
            background: linear-gradient(to right, #0047b3, #00a1ff);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 71, 179, 0.2);
        }

        .download-btn i {
            margin-left: 0.75rem;
            font-size: 1.25rem;
        }

        .download-btn:hover {
            background: linear-gradient(to right, #003a8c, #0089e0);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 71, 179, 0.25);
        }

        .data-format-info {
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: rgba(240, 249, 255, 0.8);
            border-radius: 12px;
            border-left: 4px solid #0047b3;
        }

        .data-format-title {
            font-weight: 700;
            color: #0047b3;
            margin-bottom: 0.75rem;
        }

        .data-format-text {
            color: #475569;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .loading-data-section {
                padding: 5rem 0;
            }
            
            .loading-data-description {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .loading-data-section {
                padding: 4rem 0;
                min-height: calc(100vh - 180px);
            }
            
            .loading-data-card {
                padding: 2rem 1.5rem;
            }
            
            .loading-data-title {
                font-size: 1.75rem;
                margin-bottom: 0.75rem;
            }
            
            .loading-data-icon {
                font-size: 3rem;
                margin-bottom: 1.25rem;
            }
            
            .loading-data-description {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .download-btn {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .loading-data-section {
                padding: 3rem 0;
            }
            
            .loading-data-card {
                padding: 1.75rem 1.25rem;
                border-radius: 16px;
            }
            
            .loading-data-title {
                font-size: 1.5rem;
            }
            
            .loading-data-icon {
                font-size: 2.5rem;
            }
            
            .data-format-info {
                padding: 1.25rem;
                margin-top: 1.5rem;
            }
            
            .download-btn {
                width: 100%;
                padding: 0.75rem 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="loading-data-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="loading-data-card">
                        <div class="loading-data-icon">
                            <i class="fas fa-file-download"></i>
                        </div>
                        <h2 class="loading-data-title">تحميل البيانات</h2>
                        <p class="loading-data-description">
                            يمكنك الآن تحميل قاعدة بيانات المحلات المتكاملة، والتي تحتوي على معلومات تفصيلية وإحصاءات 
                            مهمة بصيغة Excel لمساعدتك في تحليل البيانات واتخاذ القرارات المالية الصحيحة.
                        </p>
                        
                        <a href="{{ route('shops.download') }}" class="download-btn">
                            <i class="fas fa-file-excel"></i> تنزيل ملف Excel
                        </a>
                        
                        <div class="data-format-info mt-4">
                            <h5 class="data-format-title">معلومات عن الملف</h5>
                            <p class="data-format-text">
                                يحتوي الملف على بيانات مفصلة عن المحلات المسجلة في منصة سيولتك، بما في ذلك 
                                الاسم، العنوان، معلومات الاتصال، والتصنيفات.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection