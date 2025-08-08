@extends('MerchantControlPanel.parent')
@section('title', 'الإعدادات - سيولتك')
@section('page_title', 'تغيير كلمة المرور')

@section('breadcrumb')
    <li class="breadcrumb-item active">تغيير كلمة المرور</li>
@endsection

@section('styles')
<style>
    .dashboard-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.75rem;
        border: none;
        transition: all var(--transition-speed);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,71,179,0.05);
        background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
    }
    
    .dashboard-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-3px);
    }
    
    .form-card {
        max-width: 650px;
        margin: 0 auto;
    }
    
    .card-title {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }
    
    .card-title i {
        margin-left: 0.5rem;
        font-size: 1.15rem;
    }
    
    .icon-border {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary-light);
        color: var(--primary-color);
        margin-left: 0.8rem;
        transition: all 0.3s;
    }
    
    .dashboard-card:hover .icon-border {
        transform: scale(1.1);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-color);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-control, .form-select {
        border-radius: var(--border-radius-sm);
        padding: 0.65rem 0.85rem;
        border: 1px solid #e2e8f0;
        transition: all var(--transition-speed);
        font-size: 1rem;
        background-color: #f8fafc;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0,71,179,0.15);
        background-color: #fff;
    }
    
    .password-container {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 5px;
        transition: all var(--transition-speed);
        z-index: 5;
    }
    
    .password-toggle:hover, .password-toggle:focus {
        color: var(--primary-color);
    }
    
    .password-strength {
        height: 6px;
        margin-top: 8px;
        border-radius: 3px;
        transition: all 0.3s;
        background-color: #e2e8f0;
    }
    
    .strength-weak {
        background-color: var(--danger-color);
        width: 25%;
    }
    
    .strength-medium {
        background-color: var(--warning-color);
        width: 50%;
    }
    
    .strength-strong {
        background-color: var(--success-color);
        width: 75%;
    }
    
    .strength-very-strong {
        background-color: var(--success-color);
        width: 100%;
    }
    
    .strength-text {
        font-size: 0.8rem;
        margin-top: 4px;
        text-align: left;
    }
    
    .submit-btn, .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: var(--border-radius-sm);
        font-weight: 500;
        padding: 0.6rem 1.25rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: white;
        font-size: 1.05rem;
        box-shadow: 0 4px 8px rgba(0,71,179,0.2);
    }
    
    .submit-btn:hover, .btn-primary:hover, .submit-btn:focus, .btn-primary:focus {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,71,179,0.3);
    }
    
    .alert {
        border-radius: var(--border-radius-sm);
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .alert-success {
        background-color: rgba(16,185,129,0.15);
        color: var(--success-color);
    }
    
    .alert-danger {
        background-color: rgba(239,68,68,0.15);
        color: var(--danger-color);
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.5rem;
        line-height: 1.5;
    }
    
    @media (max-width: 991.98px) {
        .form-card {
            max-width: 100%;
        }
    }
    
    @media (max-width: 767.98px) {
        .dashboard-card {
            padding: 1.25rem;
        }
        
        .submit-btn, .btn-primary {
            width: 100%;
        }
        
        .card-title {
            font-size: 1.15rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .dashboard-card {
            padding: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .card-title {
            font-size: 1.05rem;
        }
        
        .icon-border {
            width: 36px;
            height: 36px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="dashboard-card mb-4">
                <div class="card-title">
                    <div class="icon-border">
                        <i class="fas fa-key"></i>
                    </div>
                    <span>تغيير كلمة المرور</span>
                </div>
                
                <div class="form-card">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                                        
                    <form method="post" action="{{route('update-password', $data->id)}}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock text-primary"></i>
                                كلمة المرور الحالية
                            </label>
                            <div class="password-container">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" placeholder="أدخل كلمة المرور الحالية" required>
                                <button type="button" class="password-toggle" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password" class="form-label">
                                <i class="fas fa-key text-primary"></i>
                                كلمة المرور الجديدة
                            </label>
                            <div class="password-container">
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" 
                                    id="new_password" placeholder="أدخل كلمة المرور الجديدة" required>
                                <button type="button" class="password-toggle" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-strength" class="password-strength"></div>
                            <div id="strength-text" class="strength-text text-muted"></div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i>
                                كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل، وتشمل حروفًا كبيرة وصغيرة وأرقام ورموز خاصة.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label">
                                <i class="fas fa-check-double text-primary"></i>
                                تأكيد كلمة المرور الجديدة
                            </label>
                            <div class="password-container">
                                <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                    id="new_password_confirmation" placeholder="أدخل تأكيد كلمة المرور الجديدة" required>
                                <button type="button" class="password-toggle" data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-match" class="mt-2 d-none">
                                <small class="text-success">
                                    <i class="fas fa-check-circle"></i> كلمات المرور متطابقة
                                </small>
                            </div>
                            <div id="password-mismatch" class="mt-2 d-none">
                                <small class="text-danger">
                                    <i class="fas fa-times-circle"></i> كلمات المرور غير متطابقة
                                </small>
                            </div>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-save me-2"></i>
                                تغيير كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
        
        const toggleButtons = document.querySelectorAll('.password-toggle');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        const newPassword = document.getElementById('new_password');
        const passwordStrength = document.getElementById('password-strength');
        const strengthText = document.getElementById('strength-text');
        
        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;
            
            passwordStrength.className = 'password-strength';
            
            if (password.length === 0) {
                passwordStrength.style.width = '0%';
                strengthText.textContent = '';
                return;
            }
            
            switch (strength) {
                case 1:
                    passwordStrength.classList.add('strength-weak');
                    strengthText.textContent = 'ضعيفة';
                    strengthText.className = 'strength-text text-danger';
                    break;
                case 2:
                case 3:
                    passwordStrength.classList.add('strength-medium');
                    strengthText.textContent = 'متوسطة';
                    strengthText.className = 'strength-text text-warning';
                    break;
                case 4:
                    passwordStrength.classList.add('strength-strong');
                    strengthText.textContent = 'قوية';
                    strengthText.className = 'strength-text text-success';
                    break;
                case 5:
                    passwordStrength.classList.add('strength-very-strong');
                    strengthText.textContent = 'قوية جداً';
                    strengthText.className = 'strength-text text-success';
                    break;
            }
        });
        
        const confirmPassword = document.getElementById('new_password_confirmation');
        const passwordMatch = document.getElementById('password-match');
        const passwordMismatch = document.getElementById('password-mismatch');
        
        function checkPasswordMatch() {
            const password = newPassword.value;
            const confirm = confirmPassword.value;
            
            if (confirm.length === 0) {
                passwordMatch.classList.add('d-none');
                passwordMismatch.classList.add('d-none');
                return;
            }
            
            if (password === confirm) {
                passwordMatch.classList.remove('d-none');
                passwordMismatch.classList.add('d-none');
            } else {
                passwordMatch.classList.add('d-none');
                passwordMismatch.classList.remove('d-none');
            }
        }
        
        newPassword.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const status = @json(session('status'));
        const icon = @json(session('icon'));
        const message = @json(session('message'));

        if (status) {
            Toast.fire({
                icon: icon || 'success',
                title: message
            });
        }

        @if ($errors->any())
            let errorMessages = {!! json_encode($errors->all()) !!};
            Toast.fire({
                icon: 'error',
                html: errorMessages.join('<br>'),
                timer: 5000
            });
        @endif
    });
</script>
@endsection