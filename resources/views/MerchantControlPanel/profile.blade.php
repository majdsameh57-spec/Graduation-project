@extends('MerchantControlPanel.parent')
@section('title', 'الملف الشخصي')
@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #0047b3 0%, #0054d7 100%);
        border-radius: var(--border-radius);
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(0, 71, 179, 0.15);
        position: relative;
        overflow: hidden;
        animation: profileHeaderFade 0.8s ease-out;
    }
    
    @keyframes profileHeaderFade {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
    }

    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #0047b3;
        margin-bottom: 0;
    }

    .profile-info {
        padding-right: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 90px
    }
    
    .profile-info h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .profile-info p {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        opacity: 0.8;
    }

    .profile-info-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.8rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 71, 179, 0.05);
        animation: cardFadeIn 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(15px);
    }
    
    @keyframes cardFadeIn {
        to { opacity: 1; transform: translateY(0); }
    }
    
    .profile-info-card:nth-child(1) { animation-delay: 0.1s; }
    .profile-info-card:nth-child(2) { animation-delay: 0.3s; }

    .profile-info-card:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-8px);
        border-color: rgba(0, 71, 179, 0.1);
    }

    .profile-info-card h4 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
    }

    .profile-info-card h4 i {
        margin-left: 0.5rem;
    }

    .profile-info-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .profile-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .profile-info-label {
        font-weight: 600;
        color: var(--text-light);
        margin-bottom: 0.35rem;
    }

    .profile-info-value {
        font-weight: 500;
        color: var(--text-color);
    }

    .profile-stats {
        display: flex;
        margin-top: 1rem;
        gap: 1rem;
    }

    .profile-stat-item {
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--border-radius-sm);
        padding: 0.75rem 1.25rem;
        text-align: center;
        flex: 1;
    }

    .profile-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .profile-stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .shop-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 71, 179, 0.05);
    }
    
    .shop-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-5px);
    }
    
    .shop-card-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .custom-modal.show {
        opacity: 1;
        visibility: visible;
    }
    
    .custom-modal-dialog {
        background: white;
        border-radius: 10px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 95%;
        transform: translateY(-30px);
        transition: transform 0.4s ease;
        overflow: hidden;
        margin: auto;
    }
    
    .custom-modal.show .custom-modal-dialog {
        transform: translateY(0);
    }
    
    .custom-modal-header {
        padding: 1.25rem;
        background: linear-gradient(to right, #0047b3, #0054d7);
        color: white;
        position: relative;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .custom-modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .custom-modal-title i {
        margin-left: 0.75rem;
    }
    
    .custom-modal-close {
        position: absolute;
        top: 1rem;
        left: 1rem;
        color: white;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0.8;
        transition: all 0.2s;
    }
    
    .custom-modal-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    
    .custom-modal-body {
        padding: 1.5rem;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    .custom-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
    }
    
    .btn-action {
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        font-weight: 500;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-action i {
        margin-left: 0.5rem;
    }
    
    .btn-view {
        background: linear-gradient(45deg, #3498db, #2980b9);
        border: none;
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        border: none;
        color: white;
    }
    
    .shop-action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .shop-info-modal-item {
        margin-bottom: 1.25rem;
    }
    
    .shop-info-modal-label {
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.35rem;
        font-size: 0.9rem;
    }
    
    .shop-info-modal-value {
        font-weight: 500;
        color: #334155;
        padding: 0.75rem;
        background-color: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    
    .view-shop-image-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .view-shop-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .profile-avatar {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .profile-header {
            padding: 1.25rem;
        }

        .profile-stats {
            flex-direction: column;
        }
        
        .shop-action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="profile-header">
        <div class="d-flex align-items-center">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p>
                    <i class="fas fa-envelope me-2"></i> {{ $user->email }}
                </p>
                @if(auth('merchant')->check() && isset($user->phone))
                <p class="mb-0">
                    <i class="fas fa-phone me-2"></i> {{ $user->phone }}
                </p>
                @endif
            </div>
        </div>

        <div class="profile-stats">
            @if(auth('merchant')->check())
            <div class="profile-stat-item">
                <div class="profile-stat-value">{{ $shopCount }}</div>
                <div class="profile-stat-label">المحلات</div>
            </div>
            <div class="profile-stat-item">
                <div class="profile-stat-value">{{ $productCount }}</div>
                <div class="profile-stat-label">المنتجات</div>
            </div>
            @elseif(auth('admin')->check())
            <div class="profile-stat-item">
                <div class="profile-stat-value">{{ $merchantCount }}</div>
                <div class="profile-stat-label">التجار</div>
            </div>
            <div class="profile-stat-item">
                <div class="profile-stat-value">{{ $shopCount }}</div>
                <div class="profile-stat-label">المحلات</div>
            </div>
            <div class="profile-stat-item">
                <div class="profile-stat-value">{{ $productCount }}</div>
                <div class="profile-stat-label">المنتجات</div>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="profile-info-card">
                <h4><i class="fas fa-user"></i> المعلومات الشخصية</h4>
                
                <div class="profile-info-item">
                    <div class="profile-info-label">الاسم</div>
                    <div class="profile-info-value">{{ $user->name }}</div>
                </div>
                
                <div class="profile-info-item">
                    <div class="profile-info-label">البريد الإلكتروني</div>
                    <div class="profile-info-value">{{ $user->email }}</div>
                </div>
                
                @if(auth('merchant')->check())
                <div class="profile-info-item">
                    <div class="profile-info-label">رقم الهاتف</div>
                    <div class="profile-info-value">{{ $user->phone ?? $user->mobile ?? '-' }}</div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-label">تاريخ الميلاد</div>
                    <div class="profile-info-value">
                        {{ isset($user->birth_date) ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '-' }}
                    </div>
                </div>
                @endif

                <div class="profile-info-item">
                    <div class="profile-info-label">تاريخ الانضمام</div>
                    <div class="profile-info-value">{{ $user->created_at->format('Y-m-d') }}</div>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-primary" onclick="openEditProfileModal()">
                        <i class="fas fa-edit me-2"></i> تعديل المعلومات الشخصية
                    </button>
                </div>
            </div>

            @if(auth('merchant')->check())
            <div class="profile-info-card">
                <h4><i class="fas fa-shield-alt"></i> الصلاحيات والأدوار</h4>
                <div class="profile-info-item">
                    <div class="profile-info-label">الدور</div>
                    <div class="profile-info-value">
                        @php
                            $merchantUser = auth('merchant')->user();
                            $roles = method_exists($merchantUser, 'roles') ? $merchantUser->roles : [];
                        @endphp
                        @if($roles && count($roles) > 0)
                            @foreach($roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">لا توجد أدوار</span>
                        @endif
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-label">الصلاحيات</div>
                    <div class="profile-info-value">
                        @php
                            $permissions = method_exists($merchantUser, 'getAllPermissions') ? $merchantUser->getAllPermissions() : [];
                        @endphp
                        @if($permissions && count($permissions) > 0)
                            @foreach($permissions as $permission)
                                <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">لا توجد صلاحيات</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-6 mb-4">
            @if(auth('merchant')->check())
            <div class="profile-info-card">
                <h4><i class="fas fa-store"></i> معلومات المتجر</h4>
                
                @if(count($shops) > 0)
                    @foreach($shops as $shop)
                    <div class="shop-card mb-3">
                        <h5 class="shop-card-title">{{ $shop->name }}</h5>
                        
                        <div class="profile-info-item">
                            <div class="profile-info-label">نشاط المتجر</div>
                            <div class="profile-info-value">{{ $shop->activity }}</div>
                        </div>
                        
                        <div class="profile-info-item">
                            <div class="profile-info-label">البريد الإلكتروني</div>
                            <div class="profile-info-value">{{ $shop->email }}</div>
                        </div>
                        
                        @if(isset($shop->phone))
                        <div class="profile-info-item">
                            <div class="profile-info-label">رقم الهاتف</div>
                            <div class="profile-info-value">{{ $shop->phone }}</div>
                        </div>
                        @endif
                        
                        <div class="shop-action-buttons">
                            <button type="button" class="btn-action btn-view" onclick="showViewModal(
                                {{ $shop->id }},
                                '{{ $shop->name }}',
                                '{{ $shop->activity }}',
                                '{{ $shop->email }}',
                                '{{ $shop->phone ?? 'غير متوفر' }}',
                                '{{ $shop->description ?? 'لا يوجد وصف' }}',
                                '{{ $shop->image ?? '' }}',
                                '{{ $shop->latitude ?? '' }}',
                                '{{ $shop->longitude ?? '' }}'
                            )">
                                <span class="w-100 d-flex justify-content-center align-items-center" style="gap:8px;">
                                    <i class="fas fa-eye"></i>
                                    <span>عرض</span>
                                </span>
                            </button>
                            <button type="button" class="btn-action btn-edit"
                                onclick="showEditModal(
                                    {{ $shop->id }},
                                    '{{ $shop->name }}',
                                    '{{ $shop->activity }}',
                                    '{{ $shop->email }}',
                                    '{{ $shop->phone ?? '' }}',
                                    '{{ $shop->description ?? '' }}',
                                    '{{ $shop->latitude ?? '' }}',
                                    '{{ $shop->longitude ?? '' }}',
                                    '{{ $shop->governorate ?? '' }}',
                                    '{{ $shop->neighborhood ?? '' }}'
                                )">
                                <span class="w-100 d-flex justify-content-center align-items-center" style="gap:8px;">
                                    <i class="fas fa-edit"></i>
                                    <span>تعديل</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> لا توجد محلات مسجلة بعد.
                    <a href="{{ route('shops.create') }}" class="alert-link me-2">إنشاء محل جديد</a>
                </div>
                @endif
            </div>
            @endif
            
            @if(auth('admin')->check())
            <div class="profile-info-card">
                <h4><i class="fas fa-shield-alt"></i> الصلاحيات والأدوار</h4>
                
                <div class="profile-info-item">
                    <div class="profile-info-label">الدور</div>
                    <div class="profile-info-value">
                        @php
                            $adminUser = auth('admin')->user();
                            $roles = method_exists($adminUser, 'roles') ? $adminUser->roles : [];
                        @endphp
                        @if($roles && count($roles) > 0)
                            @foreach($roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">لا توجد أدوار</span>
                        @endif
                    </div>
                </div>
                
                <div class="profile-info-item">
                    <div class="profile-info-label">الصلاحيات</div>
                    <div class="profile-info-value">
                        @php
                            $permissions = method_exists($adminUser, 'getAllPermissions') ? $adminUser->getAllPermissions() : [];
                        @endphp
                        @if($permissions && count($permissions) > 0)
                            @foreach($permissions as $permission)
                                <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">لا توجد صلاحيات</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="custom-modal" id="viewShopModal">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">
                <i class="fas fa-store"></i> <span id="viewShopTitle">معلومات المتجر</span>
            </h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('viewShopModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <div class="view-shop-image-container">
                <img id="viewShopImage" src="" alt="صورة المتجر" class="view-shop-image">
            </div>
            <div class="shop-info-modal-item">
                <div class="shop-info-modal-label">اسم المتجر</div>
                <div class="shop-info-modal-value" id="viewShopName"></div>
            </div>
            
            <div class="shop-info-modal-item">
                <div class="shop-info-modal-label">نشاط المتجر</div>
                <div class="shop-info-modal-value" id="viewShopActivity"></div>
            </div>

            <div class="shop-info-modal-item">
                <div class="shop-info-modal-label">عنوان المتجر</div>
                <div class="shop-info-modal-value" id="viewShopDescription"></div>
            </div>
            <div class="shop-info-modal-item" id="viewShopMapContainer" style="display:none;">
                <div class="shop-info-modal-label">الموقع على الخريطة</div>
                <div id="viewShopMap" style="height:220px; border-radius:8px; border:2px solid #e3f2fd;"></div>
            </div>

            <div class="shop-info-modal-item">
                <div class="shop-info-modal-label">البريد الإلكتروني</div>
                <div class="shop-info-modal-value" id="viewShopEmail"></div>
            </div>
            
            <div class="shop-info-modal-item">
                <div class="shop-info-modal-label">رقم الهاتف</div>
                <div class="shop-info-modal-value" id="viewShopPhone"></div>
            </div>
        </div>
    </div>
</div>

<div class="custom-modal" id="detailedShopViewModal">
    <div class="custom-modal-dialog" style="max-width: 90%; height: 90vh;">
        <div class="custom-modal-header" style="background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%);">
            <h5 class="custom-modal-title">
                <i class="fas fa-store"></i> <span id="detailedShopTitle">تفاصيل المتجر</span>
            </h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('detailedShopViewModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body p-0" style="max-height: calc(90vh - 120px); overflow-y: auto;">
            <div class="container py-3">
                <div class="shop-header mb-4" style="display: flex; flex-direction: row-reverse; gap: 40px; align-items: stretch; background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%); border-radius: 22px; padding: 40px 32px; margin: 0 0 40px 0;">
                    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <img id="detailedShopImage" src="" alt="صورة المتجر" style="border-radius:50%; width:170px; height:170px; object-fit:cover; box-shadow:0 4px 16px rgba(0,0,0,0.11); border:6px solid #fff; margin-bottom:22px;">
                        
                        <div class="shop-title" style="display: flex; align-items: center; gap: 10px; flex-direction: row-reverse;">
                            <i class="fas fa-store-alt text-dark" style="font-size:1.5rem;"></i>
                            <span id="detailedShopName" style="text-align:right; font-size:2.5rem; font-weight:bold; color:#0054d7;"></span>
                        </div>
                        
                        <div class="shop-desc" style="display: flex; align-items: center; gap: 8px; flex-direction: row-reverse; margin-top:10px;">
                            <i class="fas fa-map-marker-alt" style="font-size:1.1rem;"></i>
                            <span id="detailedShopDescription" style="text-align:right;"></span>
                        </div>
                        
                        <div class="shop-contact" style="display: flex; align-items: center; gap: 8px; flex-direction: row-reverse; margin-top:10px;">
                            <i class="bi bi-telephone" style="font-size:1.1rem;"></i>
                            <span id="detailedShopPhone" style="text-align:right;"></span>
                        </div>
                    </div>
                    
                    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <div style="font-weight:bold; color:#0054d7; font-size:1.15rem; margin-bottom:12px; text-align:right; width:100%;">
                            <i class="fas fa-info-circle me-2"></i> معلومات التواصل
                        </div>
                        <div style="background:#f8fafc; padding:25px; border-radius:15px; box-shadow:0 4px 20px rgba(0,0,0,0.05); width:100%;">
                            <div style="display:flex; flex-direction:row-reverse; margin-bottom:15px; border-bottom:1px solid #e3f2fd; padding-bottom:12px;">
                                <div style="width:100px; min-width:100px; font-weight:600; color:#64748b;">البريد الإلكتروني:</div>
                                <div id="detailedShopEmail" style="text-align:right; flex:1;"></div>
                            </div>
                            <div style="display:flex; flex-direction:row-reverse; margin-bottom:15px; border-bottom:1px solid #e3f2fd; padding-bottom:12px;">
                                <div style="width:100px; min-width:100px; font-weight:600; color:#64748b;">نشاط المتجر:</div>
                                <div id="detailedShopActivity" style="text-align:right; flex:1;"></div>
                            </div>
                            <div style="display:flex; flex-direction:row-reverse;">
                                <div style="width:100px; min-width:100px; font-weight:600; color:#64748b;">تاريخ الإنشاء:</div>
                                <div style="text-align:right; flex:1;">{{ now()->format('Y-m-d') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="products-title" style="font-size:1.6rem; font-weight:bold; color:#0054d7; margin-bottom:22px; text-align:right; font-family:'Cairo','Tajawal',Arial,sans-serif;">
                    <i class="fas fa-shopping-bag me-2"></i> المنتجات المتوفرة 🛒
                </div>
                
                <div id="detailed-shop-products-container">
                    <div class="alert alert-info" style="text-align:right;">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        جاري تحميل المنتجات...
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('detailedShopViewModal')">إغلاق</button>
        </div>
    </div>
</div>

<div class="custom-modal" id="editShopModal">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">
                <i class="fas fa-edit"></i> تعديل معلومات المتجر
            </h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('editShopModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <form id="editShopForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="edit_name" class="form-label fw-bold">اسم المتجر</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-store"></i></span>
                        <input type="text" class="form-control" id="edit_name" name="name" required placeholder="اسم المتجر">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="edit_description" class="form-label fw-bold">عنوان المتجر</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class=" fas fa-map-marker-alt"></i></span>
                        <input class="form-control" id="edit_description" name="description" rows="3" placeholder="وصف قصير عن المتجر">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">تغيير الموقع على الخريطة</label>
                    <div class="map-container" style="margin-bottom: 10px;">
                        <div id="editShopMap" style="height: 250px; border-radius: 8px; border: 2px solid #e3f2fd;"></div>
                        <div class="map-guide" style="background: rgba(255,255,255,0.9); padding: 8px 12px; border-radius: 6px; font-size: 0.85rem; border: 1px solid #e3f2fd;">
                            <i class="fas fa-info-circle text-primary"></i>
                            <span>اضغط على الخريطة لتغيير موقع المحل</span>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="edit_latitude">
                    <input type="hidden" name="longitude" id="edit_longitude">
                    <input type="hidden" name="governorate" id="edit_governorate">
                    <input type="hidden" name="neighborhood" id="edit_neighborhood">
                    <div class="mt-2 mb-3" id="edit_location_details" style="display: none;">
                        <div class="card bg-light">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        <span class="text-muted ms-2">المحافظة:</span>
                                        <strong id="edit_governorate_text"></strong>
                                    </div>
                                    <div>
                                        <i class="fas fa-street-view text-primary"></i>
                                        <span class="text-muted ms-2">الحي:</span>
                                        <strong id="edit_neighborhood_text"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="edit_activity" class="form-label fw-bold">نشاط المتجر</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        <select name="activity" class="form-select" id="edit_activity" required onchange="checkOtherActivity()">
                            <option value="" disabled selected>اختر النشاط</option>
                            <option value="بقالة">بقالة</option>
                            <option value="صيدلية">صيدلية</option>
                            <option value="مطعم">مطعم</option>
                            <option value="مقهى">مقهى</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>
                    <div class="invalid-feedback">
                        يرجى اختيار نوع النشاط
                    </div>
                </div>
                
                <!-- Field for "other" activity that appears conditionally -->
                <div class="mb-3" id="otherActivityField" style="display: none;">
                    <label for="other_activity" class="form-label fw-bold">تحديد النشاط</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                        <input type="text" class="form-control" id="other_activity" name="other_activity" placeholder="يرجى تحديد نوع النشاط">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="edit_email" class="form-label fw-bold">البريد الإلكتروني</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="edit_email" name="email" required placeholder="example@domain.com">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="edit_phone" class="form-label fw-bold">رقم الهاتف</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" id="edit_phone" name="phone" placeholder="05xxxxxxxx">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="edit_image" class="form-label fw-bold">صورة المتجر</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-success" onclick="submitEditForm()">
                <i class="fas fa-save me-1"></i> حفظ التغييرات
            </button>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="custom-modal" id="editProfileModal">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title d-flex align-items-center" style="gap: 0.5rem;">
                <span>تعديل المعلومات الشخصية</span>
                <i class="fas fa-user"></i>
            </h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('editProfileModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body" style="max-height: 70vh; overflow-y: auto;">
            <form id="editProfileForm" method="POST" action="{{ route('update-profile') }}">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="modal_name" class="form-label d-flex align-items-center" style="gap: 0.5rem;">
                        <span><i class="fas fa-user"></i> الاسم الكامل</span>
                    </label>
                    <div class="input-with-icon">
                        <input type="text" name="name" class="form-control" id="modal_name"
                            placeholder="مثال: أحمد محمد" required value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="modal_email" class="form-label d-flex align-items-center" style="gap: 0.5rem;">
                        <span><i class="fas fa-envelope"></i> البريد الإلكتروني</span>
                    </label>
                    <div class="input-with-icon">
                        <input type="email" name="email" class="form-control" id="modal_email"
                            placeholder="مثال: user@example.com" required value="{{ old('email', $user->email) }}">
                    </div>
                </div>
                @if(auth('merchant')->check())
                <div class="form-group mb-3">
                    <label for="modal_mobile" class="form-label d-flex align-items-center" style="gap: 0.5rem;">
                        <span><i class="fas fa-phone"></i> رقم الهاتف</span>
                    </label>
                    <div class="input-with-icon">
                        <input type="text" name="mobile" class="form-control" id="modal_mobile"
                            placeholder="مثال: 05xxxxxxxx" required value="{{ old('mobile', $user->mobile) }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="modal_birth_date" class="form-label d-flex align-items-center" style="gap: 0.5rem;">
                        <span><i class="fas fa-calendar-alt"></i> تاريخ الميلاد</span>
                    </label>
                    <div class="input-with-icon">
                        <input type="date" name="birth_date" class="form-control" id="modal_birth_date"
                            required value="{{ old('birth_date', $user->birth_date) }}">
                    </div>
                </div>
                @endif
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-primary" onclick="submitEditProfileForm()">
                <i class="fas fa-save me-1"></i> حفظ التغييرات
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
function showEditModal(id, name, activity, email, phone, description, latitude, longitude, governorate, neighborhood) {
    // تعبئة الحقول الأساسية
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone || '';
    document.getElementById('edit_description').value = description || '';

    // تعبئة النشاط
    const activitySelect = document.getElementById('edit_activity');
    let foundMatch = false;
    for (let i = 0; i < activitySelect.options.length; i++) {
        if (activitySelect.options[i].value === activity) {
            activitySelect.options[i].selected = true;
            foundMatch = true;
            break;
        }
    }
    if (!foundMatch) {
        activitySelect.value = "other";
        document.getElementById('otherActivityField').style.display = 'block';
        document.getElementById('other_activity').value = activity;
    } else {
        document.getElementById('otherActivityField').style.display = 'none';
    }

    // تعبئة الإحداثيات والموقع
    document.getElementById('edit_latitude').value = latitude || '';
    document.getElementById('edit_longitude').value = longitude || '';
    document.getElementById('edit_governorate').value = governorate || '';
    document.getElementById('edit_neighborhood').value = neighborhood || '';
    document.getElementById('edit_governorate_text').textContent = governorate || '';
    document.getElementById('edit_neighborhood_text').textContent = neighborhood || '';
    if (governorate || neighborhood) {
        document.getElementById('edit_location_details').style.display = 'block';
    } else {
        document.getElementById('edit_location_details').style.display = 'none';
    }

    // ضبط رابط النموذج
    document.getElementById('editShopForm').action = "{{ route('shops.update', '') }}/" + id;

    // فتح المودال
    openModal('editShopModal');

    // تهيئة الخريطة بعد ظهور المودال
    setTimeout(function() {
        if (document.getElementById('editShopMap')) {
            initEditShopMap(latitude, longitude);
            // إعادة ضبط حجم الخريطة
            window.editShopMapInstance.invalidateSize();
        }
    }, 350);
}
function initEditShopMap(lat, lng) {
    // إذا كانت الخريطة موجودة مسبقاً، احذفها
    if (window.editShopMapInstance) {
        window.editShopMapInstance.remove();
    }
    // إحداثيات افتراضية إذا لم يوجد موقع سابق
    var defaultLat = lat ? parseFloat(lat) : 31.5;
    var defaultLng = lng ? parseFloat(lng) : 34.47;

    window.editShopMapInstance = L.map('editShopMap', { attributionControl: false }).setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '© OpenStreetMap contributors' // تم إخفاء الشعار
    }).addTo(window.editShopMapInstance);

    // ضع ماركر على الموقع القديم
    var marker = L.marker([defaultLat, defaultLng], {draggable:true}).addTo(window.editShopMapInstance);

    // عند تغيير مكان الماركر
    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        document.getElementById('edit_latitude').value = pos.lat;
        document.getElementById('edit_longitude').value = pos.lng;
    });

    // عند النقر على الخريطة
    window.editShopMapInstance.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('edit_latitude').value = e.latlng.lat;
        document.getElementById('edit_longitude').value = e.latlng.lng;
    });
}
    // Modal Functions
    function showViewModal(id, name, activity, email, phone, description, image, latitude = null, longitude = null) {
        // Store shop details for reuse in detailed view
        currentShopDetails = {
            id: id,
            name: name,
            activity: activity,
            email: email,
            phone: phone,
            description: description,
            image: image
        };
        
        // Set data in the simple modal
        document.getElementById('viewShopName').textContent = name;
        document.getElementById('viewShopActivity').textContent = activity;
        document.getElementById('viewShopEmail').textContent = email;
        document.getElementById('viewShopPhone').textContent = phone;
        document.getElementById('viewShopDescription').textContent = description || 'لا يوجد وصف متاح';
        document.getElementById('viewShopTitle').textContent = "معلومات المتجر: " + name;
        
        const shopImage = document.getElementById('viewShopImage');
        
        if (image && image !== '') {
            shopImage.src = "{{ asset('storage/') }}/" + image;
        } else {
            shopImage.src = "{{ asset('images/default-shop.png') }}";
        }
        
        // Fetch shop products to display in view modal
        fetchShopProducts(id);
        
        // إعداد الخريطة إذا توفر lat/lng
        if (latitude && longitude && !isNaN(latitude) && !isNaN(longitude)) {
            document.getElementById('viewShopMapContainer').style.display = 'block';
            setTimeout(function() {
                initViewShopMap(latitude, longitude, name, description);
            }, 300);
        } else {
            document.getElementById('viewShopMapContainer').style.display = 'none';
        }
        
        openModal('viewShopModal');
    }
    
    // Current shop ID for reuse between modals
    let currentShopId = null;
    let currentShopDetails = {};
    
    // Function to fetch shop products
    function fetchShopProducts(shopId) {
        // Store current shop ID for reuse
        currentShopId = shopId;
    }
    
    // Function to show detailed shop view
    function showDetailedShopView() {
        // Close the simple view modal first
        closeModal('viewShopModal');
        
        // Set the data in the detailed view
        document.getElementById('detailedShopTitle').textContent = "تفاصيل المتجر: " + currentShopDetails.name;
        document.getElementById('detailedShopName').textContent = currentShopDetails.name;
        document.getElementById('detailedShopDescription').textContent = currentShopDetails.description || 'لا يوجد وصف متاح';
        document.getElementById('detailedShopPhone').textContent = currentShopDetails.phone;
        document.getElementById('detailedShopEmail').textContent = currentShopDetails.email;
        document.getElementById('detailedShopActivity').textContent = currentShopDetails.activity;
        
        const shopImage = document.getElementById('detailedShopImage');
        if (currentShopDetails.image && currentShopDetails.image !== '') {
            shopImage.src = "{{ asset('storage/') }}/" + currentShopDetails.image;
        } else {
            shopImage.src = "{{ asset('images/default-shop.png') }}";
        }
        
        // Load products for the detailed view
        loadDetailedProducts();
        
        // Open the detailed modal
        openModal('detailedShopViewModal');
    }
    
    // Function to load products in detailed view
    function loadDetailedProducts() {
        const productsContainer = document.getElementById('detailed-shop-products-container');
        
        // Simulate loading with placeholder content
        setTimeout(() => {
            productsContainer.innerHTML = `
                <div class="row g-4" style="flex-direction: row-reverse; justify-content: flex-start;">
                    <!-- Example Product 1 -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.07); transition:0.2s; background:#fff; border:1.5px solid #e3f2fd; overflow:hidden;">
                            <div style="height:170px; background:#f8fafc; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-box-open" style="font-size:3rem; color:#90caf9;"></i>
                            </div>
                            <div class="card-body d-flex flex-column" style="text-align:right; direction:rtl;">
                                <h5 class="card-title" style="color:#0054d7; font-size:1.18rem; font-weight:bold; display:flex; align-items:center; gap:6px;">
                                    <i class="fas fa-box-open" style="color:#0054d7; font-size:1.2rem; margin-left:4px;"></i>
                                    منتج توضيحي 1
                                </h5>
                                <p class="text-muted">وصف المنتج سيظهر هنا. يمكنك رؤية كافة تفاصيل المنتج في صفحة المتجر.</p>
                                <div style="color:#198754; font-weight:bold; font-size:1.08rem; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                                    <i class="fas fa-shekel-sign" style="color:#198754; font-size:1.1rem; margin-left:2px;"></i>
                                    50 شيكل
                                </div>
                                <div style="margin-top:8px; font-size:0.97rem;">
                                    <strong style="color:#0054d7;">طرق الدفع:</strong>
                                    <ul class="list-unstyled mt-1 mb-0">
                                        <li>💳 الدفع عند الاستلام</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Example Product 2 -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100" style="border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.07); transition:0.2s; background:#fff; border:1.5px solid #e3f2fd; overflow:hidden;">
                            <div style="height:170px; background:#f8fafc; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-gift" style="font-size:3rem; color:#90caf9;"></i>
                            </div>
                            <div class="card-body d-flex flex-column" style="text-align:right; direction:rtl;">
                                <h5 class="card-title" style="color:#0054d7; font-size:1.18rem; font-weight:bold; display:flex; align-items:center; gap:6px;">
                                    <i class="fas fa-gift" style="color:#0054d7; font-size:1.2rem; margin-left:4px;"></i>
                                    منتج توضيحي 2
                                </h5>
                                <p class="text-muted">وصف المنتج سيظهر هنا. يمكنك رؤية كافة تفاصيل المنتج في صفحة المتجر.</p>
                                <div style="color:#198754; font-weight:bold; font-size:1.08rem; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                                    <i class="fas fa-shekel-sign" style="color:#198754; font-size:1.1rem; margin-left:2px;"></i>
                                    75 شيكل
                                </div>
                                <div style="margin-top:8px; font-size:0.97rem;">
                                    <strong style="color:#0054d7;">طرق الدفع:</strong>
                                    <ul class="list-unstyled mt-1 mb-0">
                                        <li>💳 الدفع الإلكتروني</li>
                                        <li>💳 الدفع عند الاستلام</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        هذه منتجات توضيحية فقط. لرؤية المنتجات الحقيقية، يرجى زيارة صفحة المتجر.
                    </div>
                </div>
            `;
        }, 800);
    }
    
    // Function to handle "other" activity selection
    function checkOtherActivity() {
        const activitySelect = document.getElementById('edit_activity');
        const otherField = document.getElementById('otherActivityField');
        
        if (activitySelect.value === "other") {
            otherField.style.display = 'block';
            document.getElementById('other_activity').setAttribute('required', '');
        } else {
            otherField.style.display = 'none';
            document.getElementById('other_activity').removeAttribute('required');
        }
    }
    

    
    function showError(element, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-danger error-message small mt-1';
        errorDiv.textContent = message;
        
        // If the element is inside an input-group
        const parentNode = element.closest('.input-group') ? 
                          element.closest('.input-group').parentNode : 
                          element.parentNode;
        
        element.classList.add('is-invalid');
        parentNode.appendChild(errorDiv);
    }
    
    function submitEditForm() {
        // Handle other activity before submitting
        const activitySelect = document.getElementById('edit_activity');
        if (activitySelect.value === "other") {
            const otherActivity = document.getElementById('other_activity').value;
            if (otherActivity.trim()) {
                // Create a hidden field to send the custom activity
                let hiddenField = document.getElementById('hidden_other_activity');
                if (!hiddenField) {
                    hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = 'custom_activity';
                    hiddenField.id = 'hidden_other_activity';
                    document.getElementById('editShopForm').appendChild(hiddenField);
                }
                hiddenField.value = otherActivity;
            }
        }
        
        // Trigger the form's validation
        const form = document.getElementById('editShopForm');
        // Create a submit event
        const event = new Event('submit', {
            'bubbles': true,
            'cancelable': true
        });
        
        // Dispatch the event 
        const formSubmitSuccessful = form.dispatchEvent(event);
        
        // If the form validation passed, submit the form
        if (formSubmitSuccessful) {
            form.submit();
        }
    }
    
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = '';
        
        // Reset error messages when closing the modal
        if (modalId === 'editShopModal') {
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());
            
            const invalidFields = document.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => field.classList.remove('is-invalid'));
        }
    }
    
    // Initialize the "other" activity field check on page load
    document.addEventListener('DOMContentLoaded', function() {
        checkOtherActivity();
    });
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('custom-modal')) {
            closeModal(event.target.id);
        }
    });
    
    // Close modals with ESC key
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.custom-modal.show');
            modals.forEach(modal => {
                closeModal(modal.id);
            });
        }
    });
    
    // دالة تهيئة خريطة العرض
function initViewShopMap(lat, lng, name, description) {
    // إزالة الخريطة السابقة إذا وجدت
    if (window.viewShopMapInstance) {
        window.viewShopMapInstance.remove();
    }
    var map = L.map('viewShopMap', { attributionControl: false }).setView([parseFloat(lat), parseFloat(lng)], 15);
    window.viewShopMapInstance = map;
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '© OpenStreetMap contributors' // تم إخفاء الشعار
    }).addTo(map);
    var marker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(map);
    marker.bindPopup(`<strong>${name}</strong><br>${description}`).openPopup();
    setTimeout(function() { map.invalidateSize(); }, 350);
}

function openEditProfileModal() {
    document.getElementById('modal_name').value = @json($user->name);
    document.getElementById('modal_email').value = @json($user->email);
    @if(auth('merchant')->check())
    document.getElementById('modal_mobile').value = @json($user->mobile);
    document.getElementById('modal_birth_date').value = @json($user->birth_date);
    @endif
    openModal('editProfileModal');
}

function submitEditProfileForm() {
    document.getElementById('editProfileForm').submit();
}
</script>
@endsection