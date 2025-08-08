@extends('Liquidity.parent')
@section('title', 'الملف الشخصي - سيولتك')
@section('styles')
<style>
    .profile-section {
        padding: 4rem 0;
        background-color: #f8fafc;
    }
    
    .profile-header {
        background: linear-gradient(145deg, #0047b3, #005ae0);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        box-shadow: 0 10px 25px rgba(0, 71, 179, 0.12);
        margin-bottom: 2rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #0047b3;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 3px solid white;
        margin: 0 auto 1.5rem;
    }
    
    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-align: center;
    }
    
    .profile-email {
        font-size: 1rem;
        opacity: 0.9;
        text-align: center;
    }
    
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
    }
    
    .profile-card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0047b3;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .profile-card-title i {
        margin-left: 0.75rem;
        font-size: 1.1rem;
    }
    
    .profile-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .profile-info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .profile-info-label {
        font-weight: 600;
        color: #64748b;
        width: 120px;
        min-width: 120px;
    }
    
    .profile-info-value {
        color: #334155;
    }
    
    .notification-toggle {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }
    
    .notification-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .notification-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .notification-toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .notification-toggle-slider {
        background-color: #0047b3;
    }
    
    input:focus + .notification-toggle-slider {
        box-shadow: 0 0 1px #0047b3;
    }
    
    input:checked + .notification-toggle-slider:before {
        transform: translateX(24px);
    }
    
    .btn-edit-profile {
        background: linear-gradient(to right, #0047b3, #0062f5);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-edit-profile:hover {
        background: linear-gradient(to right, #003a8c, #0052cc);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 71, 179, 0.15);
    }
    
    @media (max-width: 992px) {
        .profile-section {
            padding: 3rem 0;
        }
    }
    
    @media (max-width: 768px) {
        .profile-section {
            padding: 2.5rem 0;
        }
        
        .profile-header {
            padding: 1.75rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            margin-bottom: 1.25rem;
        }
        
        .profile-name {
            font-size: 1.5rem;
        }
        
        .profile-card {
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
        }
        
        .profile-card-title {
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
        }
        
        .profile-info-item {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
        }
        
        .profile-info-label {
            margin-bottom: 0.5rem;
            width: 100%;
        }
        
        .btn-edit-profile {
            padding: 0.65rem 1.25rem;
            font-size: 0.95rem;
        }
    }
    
    @media (max-width: 576px) {
        .profile-section {
            padding: 2rem 0;
        }
        
        .profile-header {
            padding: 1.5rem 1.25rem;
        }
        
        .profile-avatar {
            width: 90px;
            height: 90px;
            font-size: 2.25rem;
        }
        
        .profile-name {
            font-size: 1.4rem;
        }
        
        .profile-email {
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h1 class="profile-name">{{ Auth::guard('web')->user()->name }}</h1>
                    <p class="profile-email">{{ Auth::guard('web')->user()->email }}</p>
                </div>
                
                <div class="profile-card">
                    <h2 class="profile-card-title">
                        <i class="fas fa-cog"></i>
                        الإعدادات السريعة
                    </h2>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">إشعارات المحلات</div>
                        <div class="profile-info-value ms-auto">
                            <label class="notification-toggle">
                                <input type="checkbox" id="shop_notifications" checked>
                                <span class="notification-toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">إشعارات المنتجات</div>
                        <div class="profile-info-value ms-auto">
                            <label class="notification-toggle">
                                <input type="checkbox" id="product_notifications" checked>
                                <span class="notification-toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">نطاق الإشعارات</div>
                        <div class="profile-info-value ms-auto">
                            <select class="form-select form-select-sm" id="notification_radius">
                                <option value="1">1 كم</option>
                                <option value="3">3 كم</option>
                                <option value="5" selected>5 كم</option>
                                <option value="10">10 كم</option>
                                <option value="20">20 كم</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="profile-card mb-4">
                    <h2 class="profile-card-title">
                        <i class="fas fa-user-circle"></i>
                        معلومات المستخدم
                    </h2>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">الاسم</div>
                        <div class="profile-info-value">{{ Auth::guard('web')->user()->name }}</div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">البريد الإلكتروني</div>
                        <div class="profile-info-value">{{ Auth::guard('web')->user()->email }}</div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">العنوان</div>
                        <div class="profile-info-value">{{ Auth::guard('web')->user()->address }}</div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">رقم الهاتف</div>
                        <div class="profile-info-value">{{ Auth::guard('web')->user()->phone ?? 'غير محدد' }}</div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-label">تاريخ التسجيل</div>
                        <div class="profile-info-value">{{ Auth::guard('web')->user()->created_at->format('Y-m-d') }}</div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button class="btn btn-edit-profile">
                            <i class="fas fa-edit me-2"></i> تعديل البيانات الشخصية
                        </button>
                    </div>
                </div>
                
                <div class="profile-card">
                    <h2 class="profile-card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        المحلات القريبة
                    </h2>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        سيتم عرض المحلات القريبة من موقعك بناءً على العنوان المسجل في حسابك.
                    </div>
                    
                    <div id="nearby-shops">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">جاري التحميل...</span>
                            </div>
                            <p class="mt-2">جاري البحث عن المحلات القريبة...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function saveNotificationSettings() {
        const settings = {
            shopNotifications: document.getElementById('shop_notifications').checked,
            productNotifications: document.getElementById('product_notifications').checked,
            notificationRadius: document.getElementById('notification_radius').value
        };
        
        localStorage.setItem('notificationSettings', JSON.stringify(settings));
        
        console.log("Notification settings saved:", settings);
        
        loadNearbyShops();
    }
    
    function loadNotificationSettings() {
        const savedSettings = localStorage.getItem('notificationSettings');
        
        if (savedSettings) {
            const settings = JSON.parse(savedSettings);
            
            document.getElementById('shop_notifications').checked = settings.shopNotifications;
            document.getElementById('product_notifications').checked = settings.productNotifications;
            document.getElementById('notification_radius').value = settings.notificationRadius;
        }
    }
    
    function getUserLocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        localStorage.setItem('userLocation', JSON.stringify(location));
                        resolve(location);
                    },
                    error => {
                        console.log('Error getting location:', error.message);
                        const savedLocation = localStorage.getItem('userLocation');
                        if (savedLocation) {
                            resolve(JSON.parse(savedLocation));
                        } else {
                            const defaultLocation = { lat: 31.5017, lng: 34.4668 };
                            localStorage.setItem('userLocation', JSON.stringify(defaultLocation));
                            resolve(defaultLocation);
                        }
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 60000 }
                );
            } else {
                const defaultLocation = { lat: 31.5017, lng: 34.4668 };
                localStorage.setItem('userLocation', JSON.stringify(defaultLocation));
                resolve(defaultLocation);
            }
        });
    }
    
    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        const d = R * c;
        return d;
    }
    
    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }
    
    let lastNearbyShopProducts = {};
    let lastNearbyShopIds = [];
    function loadNearbyShops() {
        const nearbyShopsElement = document.getElementById('nearby-shops');
        const notificationRadius = parseFloat(document.getElementById('notification_radius').value);
        nearbyShopsElement.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">جاري التحميل...</span>
                </div>
                <p class="mt-2">جاري البحث عن المحلات القريبة في نطاق ${notificationRadius} كم...</p>
            </div>
        `;
        getUserLocation().then(userLocation => {
            fetch(`/your-liquidity/user/nearby-shops?lat=${userLocation.lat}&lng=${userLocation.lng}&radius=${notificationRadius}`)
                .then(response => response.json())
                .then(async data => {
                    if (data.shops && data.shops.length > 0) {
                        let shopsHTML = '';
                        let newShopIds = data.shops.map(shop => shop.id);
                        if (window.lastNearbyShopIds && window.lastNearbyShopIds.length > 0) {
                            const addedShops = data.shops.filter(shop => !window.lastNearbyShopIds.includes(shop.id));
                            if (addedShops.length > 0 && document.getElementById('shop_notifications').checked) {
                            }
                        }
                        window.lastNearbyShopIds = newShopIds;
                        if (document.getElementById('product_notifications').checked) {
                            for (const shop of data.shops) {
                                try {
                                    const res = await fetch(`/your-liquidity/shops/${shop.id}/products?limit=1&sort=desc`);
                                    if (res.ok) {
                                        const prodData = await res.json();
                                        if (prodData.products && prodData.products.length > 0) {
                                            const latestProduct = prodData.products[0];
                                            if (!lastNearbyShopProducts[shop.id] || lastNearbyShopProducts[shop.id] !== latestProduct.id) {
                                                if (lastNearbyShopProducts[shop.id] !== undefined) {
                                                }
                                                lastNearbyShopProducts[shop.id] = latestProduct.id;
                                            }
                                        }
                                    }
                                } catch (e) {  }
                            }
                        }
                        data.shops.forEach(shop => {
                            shopsHTML += `
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title fw-bold mb-1">${shop.name}</h5>
                                            <p class="card-text text-muted small mb-0">${shop.address ?? ''}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary mb-2">${shop.distance} كم</span>
                                            <div>
                                                <a href="/your-liquidity/shops/${shop.id}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-external-link-alt me-1"></i> عرض
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        nearbyShopsElement.innerHTML = shopsHTML;
                    } else {
                        window.lastNearbyShopIds = [];
                        lastNearbyShopProducts = {};
                        nearbyShopsElement.innerHTML = `
                            <div class="text-center py-4">
                                <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                <p>لا توجد محلات قريبة في نطاق ${notificationRadius} كم من موقعك حاليًا.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading nearby shops:', error);
                    nearbyShopsElement.innerHTML = `
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <p>حدث خطأ أثناء جلب المحلات القريبة. حاول مرة أخرى.</p>
                        </div>
                    `;
                });
        }).catch(error => {
            console.error('Error loading location:', error);
            nearbyShopsElement.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>لم نتمكن من تحديد موقعك. يرجى السماح بالوصول إلى الموقع لعرض المحلات القريبة.</p>
                    <button id="retry-location" class="btn btn-primary mt-2">
                        <i class="fas fa-location-arrow me-1"></i> تحديد الموقع
                    </button>
                </div>
            `;
            setTimeout(() => {
                const retryButton = document.getElementById('retry-location');
                if (retryButton) {
                    retryButton.addEventListener('click', loadNearbyShops);
                }
            }, 100);
        });
    }
    
    document.getElementById('shop_notifications').addEventListener('change', saveNotificationSettings);
    document.getElementById('product_notifications').addEventListener('change', saveNotificationSettings);
    document.getElementById('notification_radius').addEventListener('change', saveNotificationSettings);
    
    loadNotificationSettings();
    loadNearbyShops();
    
    const editProfileButton = document.querySelector('.btn-edit-profile');
    if (editProfileButton) {
        editProfileButton.addEventListener('click', function() {
            window.location.href = "{{ route('user.profile.edit') }}";
        });
    }
});
</script>
@endsection