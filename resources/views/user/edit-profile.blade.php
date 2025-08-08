@extends('Liquidity.parent')
@section('title', 'تعديل الملف الشخصي - سيولتك')
@section('styles')
<style>
    .edit-profile-section {
        padding: 4rem 0;
        background-color: #f8fafc;
    }
    
    .edit-profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .edit-profile-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0047b3;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    
    .edit-profile-subtitle {
        color: #64748b;
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #334155;
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
    
    .btn-update-profile {
        background: linear-gradient(to right, #0047b3, #0062f5);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-update-profile:hover {
        background: linear-gradient(to right, #003a8c, #0052cc);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 71, 179, 0.15);
    }
    
    .btn-cancel {
        background: transparent;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-cancel:hover {
        background: #f8fafc;
        color: #334155;
        border-color: #cbd5e1;
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
</style>
@endsection

@section('content')
<section class="edit-profile-section">
    <div class="container">
        <div class="edit-profile-card">
            <h1 class="edit-profile-title">
                <i class="fas fa-user-edit me-2"></i>تعديل البيانات الشخصية
            </h1>
            <p class="edit-profile-subtitle">قم بتعديل بياناتك الشخصية وحفظ التغييرات</p>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">الاسم</label>
                    <div class="input-with-icon">
                        <input type="text" name="name" id="name" class="form-control" 
                               value="{{ old('name', $user->name) }}" required>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <div class="input-with-icon">
                        <input type="email" class="form-control bg-light" 
                               value="{{ $user->email }}" disabled>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <small class="text-muted">لا يمكن تغيير البريد الإلكتروني</small>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">العنوان</label>
                    <div class="input-with-icon">
                        <input type="text" name="address" id="address" class="form-control" 
                               value="{{ old('address', $user->address) }}" required>
                        <div class="input-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <div class="input-with-icon">
                        <input type="tel" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $user->phone) }}" placeholder="مثال: 05xxxxxxxx">
                        <div class="input-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('user.profile') }}" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i> إلغاء
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-update-profile">
                            <i class="fas fa-save me-2"></i> حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
