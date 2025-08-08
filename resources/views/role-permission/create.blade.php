@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - إنشاء دور')
@section('page_title', 'إدارة الأدوار')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الأدوار</a></li>
    <li class="breadcrumb-item active">إنشاء دور جديد</li>
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dashboard-card mb-4">
                <div class="card-title">
                    <div class="icon-border">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <span>إنشاء دور جديد</span>
                </div>
                
                <div class="form-card">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            يرجى تصحيح الأخطاء التالية:
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <ul class="mt-2 mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('roles.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="guard" class="form-label">
                                <i class="fas fa-shield-alt text-primary"></i>
                                نوع المستخدم
                            </label>
                            <select class="form-select @error('guard') is-invalid @enderror" name="guard" id="guard">
                                @foreach ($guards as $guard)
                                    <option value="{{ $guard['value'] }}">{{ $guard['name'] }}</option>
                                @endforeach
                            </select>
                            @error('guard')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag text-primary"></i>
                                اسم الدور
                            </label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                placeholder="أدخل اسم الدور" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-save me-2"></i>
                                حفظ الدور
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

        bsCustomFileInput?.init();

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