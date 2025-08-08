@extends('Liquidity.parent')
@section('title', 'إعادة تعيين كلمة المرور - سيولتك')

@section('styles')
<style>
    .reset-section{
        padding:4rem 0;
        min-height:calc(100vh - 150px);
        display:flex;align-items:center;justify-content:center;
        background-color:rgba(245,247,250,.8);
        background-image:url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 1500"%3E%3Cdefs%3E%3CradialGradient id="a"%3E%3Cstop offset="0" stop-color="%23ffffff"/%3E%3Cstop offset="1" stop-color="%23f5f7fa"/%3E%3C/radialGradient%3E%3C/defs%3E%3Cpath fill="url(%23a)" d="M0 0h2000v1500H0z"/%3E%3C/svg%3E');
        background-size:cover;
    }
    .reset-section .container{display:flex;align-items:center;justify-content:center;height:100%}

    .reset-card{
        max-width:460px;width:100%;
        background:#fff;padding:2.5rem 2rem;
        border-radius:16px;box-shadow:0 10px 25px rgba(0,0,0,0.08);
        position:relative;overflow:hidden;
    }
    .reset-card::before{
        content:'';position:absolute;top:0;left:0;width:100%;height:8px;
        background:linear-gradient(to right,#0047b3,#00a1ff);
    }

    .reset-title{font-size:1.75rem;font-weight:700;color:#0047b3;margin-bottom:1.5rem;text-align:center}
    .reset-subtitle{color:#64748b;text-align:center;margin-bottom:2rem;font-size:.95rem}

    .form-group{margin-bottom:1.5rem}
    .form-label{font-weight:600;color:#334155;margin-bottom:.5rem;display:block}
    .form-control{
        background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;
        padding:.75rem 1rem;width:100%;transition:.3s;
    }
    .form-control:focus{
        border-color:#0047b3;box-shadow:0 0 0 3px rgba(0,71,179,.1);background:#fff;
    }
    .input-with-icon{position:relative}
    .input-icon{
        position:absolute;top:50%;right:1rem;transform:translateY(-50%);
        color:#94a3b8
    }
    .input-with-icon .form-control{padding-right:2.5rem}

    .reset-btn{
        background:linear-gradient(to right,#0047b3,#0062f5);color:#fff;
        border:none;border-radius:10px;padding:.75rem 1rem;font-weight:600;width:100%;
        margin-top:1rem;cursor:pointer;transition:.3s;
    }
    .reset-btn:hover{
        background:linear-gradient(to right,#003a8c,#0052cc);
        transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,71,179,.15)
    }

    .reset-links{text-align:center;margin-top:1.5rem;font-size:.95rem}
    .reset-link{color:#0047b3;font-weight:600;text-decoration:none;transition:.3s}
    .reset-link:hover{color:#0052cc;text-decoration:underline}

    .login-divider {
        margin: 1.5rem 0;
        display: flex;
        align-items: center;
        text-align: center;
        color: #94a3b8;
    }

    .login-divider::before,
    .login-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }

    .login-divider::before {
        margin-right: 0.5rem;
    }

    .login-divider::after {
        margin-left: 0.5rem;
    }

    @media(max-width:576px){
        .reset-card{padding:2rem 1.5rem;margin:0 1rem}
    }
</style>
@endsection

@section('content')
<section class="reset-section">
    <div class="container">
        <div class="reset-card">
            <h2 class="reset-title">🔒 استعادة كلمة المرور</h2>
            <p class="reset-subtitle">أدخل بريدك الإلكتروني لنرسل لك رابط إعادة التعيين</p>
            
            @if(session('status'))
                <div class="alert alert-success" style="background-color: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger" style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;">
                    <ul style="margin: 0; padding-right: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <div class="input-with-icon">
                        <input type="email" name="email" id="email" class="form-control"
                               placeholder="merchant@email.com" required value="{{ old('email') }}">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    </div>
                </div>

                <button type="submit" class="reset-btn">
                    <i class="fas fa-paper-plane me-2"></i> إرسال رابط الاستعادة
                </button>

                <div class="reset-links">
                    <div class="login-divider">أو</div>
                    <p>تذكرت كلمة المرور؟ <a href="{{ route('login') }}" class="reset-link">تسجيل الدخول الآن</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
