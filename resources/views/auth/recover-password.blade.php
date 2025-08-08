@extends('Liquidity.parent')
@section('title', 'الإعدادات - سيولتك')
@section('styles')

@endsection
@section('content')
    <div class="container mt-3">
        <div class="col-5 p-5 max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100 fade-in">
            <h1 class="text-3xl font-bold text-[#0054d7] mb-8 flex items-center gap-2">تغيير كلمة المرور </h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <div class="input-group">
                        <span class="input-group-text"></span>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"></span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-check-circle me-2"></i>تغيير كلمة المرور
                </button>

                <div class="text-center mt-3">
                    <a href="" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-right"></i> العودة لتسجيل الدخول
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
