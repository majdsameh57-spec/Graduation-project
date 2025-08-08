@extends('MerchantControlPanel.parent')

@section('title', 'سيولتك - تسجيل محل جديد')
@section('page_title', 'تسجيل محل جديد')

@section('breadcrumb')
    <li class="breadcrumb-item active">تسجيل محل جديد</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 350px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,71,179,0.07);
        border: 2px solid #e3f2fd;
        margin-bottom: 15px;
        width: 100%;
    }
    .map-container {
        position: relative;
    }
    .map-container .map-guide {
        position: absolute;
        bottom: 10px;
        left: 10px;
        z-index: 500;
        background: rgba(255,255,255,0.9);
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        border: 1px solid #e3f2fd;
    }
    .form-section {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .form-section-title {
        font-weight: 600;
        color: #0047b3;
        margin-bottom: 1rem;
    }
    .required-field::after {
        content: "*";
        color: #dc3545;
        margin-right: 4px;
    }
    .activity-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-top: 10px;
        background-color: #e3f2fd;
        color: #0047b3;
        border: 1px solid #b6d4fe;
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 10px;
        color: #6c757d;
    }
    .leaflet-control-attribution { display: none !important; }
    @media (max-width: 767.98px) {
        #map { height: 250px; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-mt-12 mx-auto">
            <div class="dashboard-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title m-0">
                        <i class="fas fa-store"></i>
                        <span>تسجيل محل جديد</span>
                    </h3>
                </div>

                <form method="POST" action="{{ route('shops.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-info-circle me-2"></i>البيانات الأساسية
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">اسم المحل</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}" 
                                           placeholder="مثال: سوبر ماركت ياسين" required>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال اسم المحل
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required-field">نوع النشاط</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                    <select name="activity" class="form-select" id="activity-type" required>
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
                            
                            <div id="other-activity-container" class="col-12" style="display: none;">
                                <label class="form-label">تحديد النشاط الآخر</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                    <input type="text" class="form-control" name="other_activity" value="{{ old('other_activity') }}"
                                        id="other-activity" placeholder="أدخل النشاط المخصص">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-phone-alt me-2"></i>بيانات الاتصال
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">رقم هاتف المتجر</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    <input name="phone" type="text" class="form-control" dir="ltr" value="{{ old('phone') }}" 
                                           placeholder="مثال: 0599123456" required>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال رقم هاتف صحيح
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required-field">العنوان المختصر</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-signs"></i></span>
                                    <input name="description" type="text" class="form-control" value="{{ old('description') }}"
                                        placeholder="مثال: غزة - شارع الوحدة، قرب محطة كذا" required>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال العنوان المختصر للمحل
                                </div>
                            </div>
                            
                            <div class="col-md-6 d-none">
                                <input type="email" class="form-control" name="email" value="{{ $merchant->email ?? '' }}">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-map-marked-alt me-2"></i>تحديد الموقع
                        </h4>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required-field">تحديد الموقع على الخريطة</label>
                                <div class="map-container">
                                    <div id="map"></div>
                                    <div class="map-guide">
                                        <i class="fas fa-info-circle text-primary"></i>
                                        <span>اضغط على الخريطة لتحديد موقع المحل بدقة</span>
                                    </div>
                                </div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <input type="hidden" name="governorate" id="governorate">
                                <input type="hidden" name="neighborhood" id="neighborhood">
                                
                                <div class="mt-2 mb-3 d-none" id="location-details">
                                    <div class="card bg-light">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                                    <span class="text-muted ms-2">المحافظة:</span>
                                                    <strong id="governorate-text"></strong>
                                                </div>
                                                <div>
                                                    <i class="fas fa-street-view text-primary"></i>
                                                    <span class="text-muted ms-2">الحي:</span>
                                                    <strong id="neighborhood-text"></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-image me-2"></i>الصورة
                        </h4>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="image" class="form-label">اختر صورة للمحل</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">يفضل استخدام صور بمقاس 1:1 أو 4:3</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>
                                <span>تسجيل المتجر</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var gazaStripCenter = [31.45, 34.35];
    var map = L.map('map').setView(gazaStripCenter, 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var bounds = L.latLngBounds([31.22, 34.19], [31.60, 34.55]);
    map.setMaxBounds(bounds);
    map.on('drag', function() {
        map.panInsideBounds(bounds, { animate: false });
    });

    setTimeout(() => {
        map.invalidateSize();
    }, 100);

    var marker;

    function getNearestGovernorate(lat, lng) {
        if (lat >= 31.53) return "الشمال";
        if (lat >= 31.45 && lat < 31.53) return "غزة";
        if (lat >= 31.35 && lat < 31.45) return "الوسطى";
        if (lat >= 31.22 && lat < 31.35 && lng >= 34.25 && lng <= 34.38) return "خانيونس";
        if (lat >= 31.22 && lat < 31.35 && lng > 34.38) return "رفح";
        return "غزة";
    }

    function getNearestNeighborhood(lat, lng) {
        if (lat >= 31.53 && lat <= 31.6 && lng >= 34.48 && lng <= 34.55) return "تل الزعتر";
        if (lat >= 31.5 && lat < 31.53 && lng >= 34.45 && lng <= 34.55) return "الرمال";
        if (lat >= 31.4 && lat < 31.5 && lng >= 34.35 && lng <= 34.45) return "دير البلح";
        if (lat >= 31.35 && lat < 31.4 && lng >= 34.3 && lng <= 34.4) return "بني سهيلا";
        if (lat >= 31.22 && lat < 31.35 && lng >= 34.25 && lng <= 34.35) return "تل السلطان";
        if (lat >= 31.53) return "تل الزعتر";
        if (lat >= 31.5) return "الرمال";
        if (lat >= 31.4) return "دير البلح";
        if (lat >= 31.35) return "بني سهيلا";
        return "تل السلطان";
    }

    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        
        const mapContainer = document.querySelector('.map-container');
        let loadingIndicator = mapContainer.querySelector('.map-loading');
        if (!loadingIndicator) {
            loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'map-loading';
            loadingIndicator.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">جاري التحميل...</span></div>';
            loadingIndicator.style.position = 'absolute';
            loadingIndicator.style.top = '50%';
            loadingIndicator.style.left = '50%';
            loadingIndicator.style.transform = 'translate(-50%, -50%)';
            loadingIndicator.style.zIndex = '1000';
            loadingIndicator.style.background = 'rgba(255,255,255,0.8)';
            loadingIndicator.style.padding = '10px';
            loadingIndicator.style.borderRadius = '4px';
            mapContainer.appendChild(loadingIndicator);
        } else {
            loadingIndicator.style.display = 'block';
        }
        
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                const govMap = {
                    "Gaza": "غزة",
                    "North Gaza": "الشمال",
                    "Khan Yunis": "خانيونس",
                    "Rafah": "رفح",
                    "Deir al-Balah": "الوسطى",
                    "Deir al Balah": "الوسطى",
                    "Deir Al Balah": "الوسطى",
                    "Gaza Strip": "غزة",
                };

                const neighMap = {
                    "Jabalia": "جباليا البلد", "Jabalia Camp": "مخيم جباليا", "Beit Lahia": "بيت لاهيا",
                    "Beit Hanoun": "بيت حانون", "Tel al-Zaatar": "تل الزعتر", "Northern Rimal": "الرمال الشمالي",
                    "Southern Rimal": "الرمال الجنوبي", "Tal al-Hawa": "تل الهوى", "Sheikh Radwan": "الشيخ رضوان",
                    "Al-Zeitoun": "الزيتون", "Al-Daraj": "الدرج", "Al-Shuja'iya": "الشجاعية", "Ash-Sabra": "الصبرة",
                    "Sheikh Ajleen": "الشيخ عجلين", "Industrial Area": "المنطقة الصناعية", "At-Tuffah": "التفاح",
                    "Al-Nasser": "النصر", "Al-Mina": "الميناء", "Al-Masdar": "المصدر", "Al-Shati Camp": "مخيم الشاطئ",
                    "An-Nuseirat": "النصيرات", "Al-Zawaida": "الزوايدة", "Deir al-Balah": "دير البلح",
                    "Al-Maghazi": "المغازي", "Al-Bureij": "البريج", "Al-Zahraa": "الزهراء", "Wadi as-Salqa": "وادي السلقا",
                    "Khan Yunis": "خان يونس البلد", "Western Camp": "المعسكر الغربي", "Bani Suhaila": "بني سهيلا",
                    "Al-Qarara": "القرارة", "Khuza'a": "خزاعة", "Abasan al-Kabira": "عبسان الكبيرة",
                    "Abasan al-Saghira": "عبسان الصغيرة", "Eastern Area": "المنطقة الشرقية", "Western Area": "المنطقة الغربية",
                    "Austrian Neighborhood": "الحي النمساوي", "Japanese Neighborhood": "الحي الياباني", "Hope Neighborhood": "حي الأمل",
                    "Khan Yunis Industrial Area": "المنطقة الصناعية خانيونس", "Rafah": "رفح البلد", "Tel al-Sultan": "تل السلطان",
                    "Al-Shabura": "الشابورة", "South Rafah": "جنوب رفح", "Al-Salam Neighborhood": "حي السلام",
                    "Al-Nasr Neighborhood": "حي النصر", "Al-Jenina Neighborhood": "حي الجنينة", "Yabna": "يبنا",
                    "Brazil": "البرازيل", "Khirbet al-Adas": "خربة العدس", "Al-Bayouk": "البيوك", "Rafah Camp": "مخيم رفح",
                    "Saudi Neighborhood": "الحي السعودي", "Administrative Neighborhood": "الحي الإداري", "Al-Shawka": "الشوكة", "Airport": "المطار"
                };

                let gov = data.address?.state || data.address?.city || data.address?.county || data.address?.region || '';
                let neigh = data.address?.suburb || data.address?.neighbourhood || data.address?.village || '';

                if (!gov || gov === 'غير محدد' || gov === 'قطاع غزة' || gov === 'Gaza Strip') {
                    gov = getNearestGovernorate(lat, lng);
                } else {
                    gov = govMap[gov] || gov;
                }

                neigh = neighMap[neigh] || neigh;
                if (!neigh || neigh === 'غير محدد') {
                    neigh = getNearestNeighborhood(lat, lng);
                }

                document.getElementById('governorate').value = gov;
                document.getElementById('neighborhood').value = neigh;
                
                const locationDetails = document.getElementById('location-details');
                if (locationDetails) {
                    locationDetails.classList.remove('d-none');
                    document.getElementById('governorate-text').textContent = gov;
                    document.getElementById('neighborhood-text').textContent = neigh;
                }
                
        let mapContainer = document.querySelector('.map-container');
        let oldMsg = mapContainer.querySelector('.location-success-msg');
        if (oldMsg) oldMsg.remove();
        const msg = document.createElement('div');
        msg.className = 'alert alert-success location-success-msg';
        msg.style.position = 'absolute';
        msg.style.top = '10px';
        msg.style.right = '10px';
        msg.style.zIndex = '1200';
        msg.innerHTML = `<i class="fas fa-check-circle me-2"></i>تم تحديد الموقع بنجاح في ${gov} - ${neigh}`;
        mapContainer.appendChild(msg);
        setTimeout(() => { if(msg) msg.remove(); }, 3000);
                
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
            })
            .catch(err => {
                console.error('Error fetching location data:', err);
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
                
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                const gov = getNearestGovernorate(lat, lng);
                const neigh = getNearestNeighborhood(lat, lng);
                
                document.getElementById('governorate').value = gov;
                document.getElementById('neighborhood').value = neigh;
                
                const locationDetails = document.getElementById('location-details');
                if (locationDetails) {
                    locationDetails.classList.remove('d-none');
                    document.getElementById('governorate-text').textContent = gov;
                    document.getElementById('neighborhood-text').textContent = neigh;
                }
            });
    });

    var form = document.querySelector('.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        if (!document.getElementById('governorate').value || !document.getElementById('neighborhood').value) {
            event.preventDefault();
            
            const mapContainer = document.querySelector('.map-container');
            const alertEl = document.createElement('div');
            alertEl.className = 'alert alert-danger mt-2';
            alertEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>يجب تحديد الموقع على الخريطة';
            mapContainer.appendChild(alertEl);
            
            setTimeout(() => {
                alertEl.remove();
            }, 3000);
            
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        form.classList.add('was-validated');
    }, false);

    const activitySelect = document.getElementById('activity-type');
    const otherActivityContainer = document.getElementById('other-activity-container');
    const otherActivityInput = document.getElementById('other-activity');
    
    activitySelect.addEventListener('change', function() {
        if (this.value === 'other') {
            otherActivityContainer.style.display = 'block';
            otherActivityInput.setAttribute('required', '');
        } else {
            otherActivityContainer.style.display = 'none';
            otherActivityInput.removeAttribute('required');
        }
    });
    
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                let previewContainer = document.querySelector('.image-preview');
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'image-preview mt-3';
                    previewContainer.style.maxWidth = '200px';
                    imageInput.parentNode.appendChild(previewContainer);
                }
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" alt="Preview">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">${file.name}</small>
                            </div>
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
