@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - انشاء حساب مدير جديد')
@section('page_title', 'انشاء حساب مدير جديد')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">المدراء</a></li>
    <li class="breadcrumb-item active">انشاء حساب جديد</li>
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
        width: 100%;
        max-width: 100%;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        margin: 0;
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
    
    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-light);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
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
    
    .custom-file-container {
        position: relative;
        overflow: hidden;
    }
    
    .custom-file-label {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-sm);
        padding: 0.65rem 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1rem;
        transition: all var(--transition-speed);
    }
    
    .custom-file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .custom-file-text {
        margin-right: auto;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .submit-btn {
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
    
    .submit-btn:hover, .submit-btn:focus {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,71,179,0.3);
    }
    
    .input-group {
        border-radius: var(--border-radius-sm);
        overflow: hidden;
    }
    
    .input-group .btn {
        background-color: #e2e8f0;
        border-color: #e2e8f0;
        color: var(--text-color);
        transition: all var(--transition-speed);
    }
    
    .input-group .btn:hover {
        background-color: #cbd5e1;
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
    
    @media (max-width: 991.98px) {
        .form-card {
            max-width: 100%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .dashboard-card {
            padding: 1.25rem;
        }
        
        .submit-btn {
            width: 100%;
        }
        
        .card-title {
            font-size: 1.15rem;
        }
        
        .section-title {
            font-size: 1rem;
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="dashboard-card mb-6">
                <div class="card-title">
                    <div class="icon-border">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span>انشاء حساب مدير جديد</span>
                </div>
                <div class="form-card">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ route('admins.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <h5 class="section-title">البيانات الأساسية</h5>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user text-primary"></i>
                                    اسم المدير
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope text-primary"></i>
                                    البريد الالكتروني
                                </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock text-primary"></i>
                                    كلمة المرور
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{ old('password') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="mobile" class="form-label">
                                    <i class="fas fa-mobile-alt text-primary"></i>
                                    رقم الهاتف
                                </label>
                                <div class="input-group">
                                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ old('mobile') }}" required>
                                </div>
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <h5 class="section-title mt-4">معلومات إضافية</h5>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="image" class="form-label">
                                    <i class="fas fa-image text-primary"></i>
                                    صورة المدير
                                </label>
                                <div class="custom-file-container">
                                    <label class="custom-file-label" for="image">
                                        <i class="fas fa-upload me-2"></i>
                                        <span class="custom-file-text">اختر صورة...</span>
                                    </label>
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                </div>
                                <div class="mt-2 text-muted small">
                                    <i class="fas fa-info-circle"></i>
                                    الصور المسموحة: JPG, PNG, GIF بحجم لا يزيد عن 2MB
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="role_id" class="form-label">
                                    <i class="fas fa-user-tag text-primary"></i>
                                    دور المستخدم
                                </label>
                                <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                    <option value="" disabled selected>اختر الدور...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-user-plus me-2"></i>
                                إنشاء الحساب
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        
        const fileInput = document.getElementById('image');
        const fileLabel = document.querySelector('.custom-file-text');
        
        fileInput.addEventListener('change', function() {
            if(this.files && this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = 'اختر صورة...';
            }
        });
        
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