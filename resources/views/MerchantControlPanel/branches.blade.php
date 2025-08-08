@extends('MerchantControlPanel.parent')

@section('title', 'سيولتك - إدارة الفروع')
@section('page_title', 'إدارة الفروع')

@section('breadcrumb')
    <li class="breadcrumb-item active">إدارة مواقع الفروع</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    #branch-map {
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
    .branch-list-card {
        margin-top: 30px;
        border-radius: 8px;
        border-top: 3px solid #0047b3;
    }
    .branch-item {
        background-color: #f8fafc;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    .branch-item:hover {
        box-shadow: 0 4px 12px rgba(0,71,179,0.1);
        transform: translateY(-2px);
    }
    .branch-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .branch-name {
        font-weight: 600;
        color: #0047b3;
        font-size: 1.1rem;
    }
    .leaflet-control-attribution { display: none !important; }
    @media (max-width: 767.98px) {
        #branch-map { height: 250px; }
        .branch-actions { 
            width: 100%; 
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-mt-12 mx-auto">
            <div class="dashboard-card mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                        <i class=" fas fa-map-marker-alt"style="color: #0047b3;"></i>
                        <span class="card-title m-0">إدارة الفروع</span>
                    </div>
                </div>
                <form id="add-branch-form" action="{{ route('branches.custom-store') }}" method="post" class="row g-3 mb-4">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">المحل</label>
                        <select name="shop_id" id="shop_id" required class="form-select">
                            <option value="">اختر المحل</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}" data-name="{{ $shop->name }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان المختصر</label>
                        <input type="text" name="location" class="form-control"
                               placeholder="العنوان المختصر (مثال: الرمال، شارع النصر)" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-phone-alt"></i>
                            <span>رقم هاتف الفرع</span>
                        </label>
                        <input type="text" name="phone_number" class="form-control" 
                               dir="ltr" placeholder="مثال: 0599123456" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>تحديد موقع الفرع على الخريطة</span>
                        </label>
                        <div class="map-container">
                            <div id="branch-map"></div>
                            <div class="map-guide">
                                <i class="fas fa-info-circle text-primary"></i>
                                <span>اضغط على الخريطة لتحديد موقع الفرع بدقة</span>
                            </div>
                        </div>
                        <input type="hidden" name="latitude" id="branch-latitude">
                        <input type="hidden" name="longitude" id="branch-longitude">
                        <input type="hidden" name="governorate" id="branch-governorate">
                        <input type="hidden" name="neighborhood" id="branch-neighborhood">
                        
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i>
                            <span>حفظ الفرع</span>
                        </button>
                    </div>
                </form>
                <div id="branches-section" style="display:none;">
                    <div id="branches-heading" class="mb-3 h5 text-primary d-flex align-items-center gap-2">
                        <i class="fas fa-list-ul"></i>
                        <span id="branches-shop-title">الفروع التابعة للمحل</span>
                    </div>
                    <div id="branches-list">
                        @forelse($branches as $branch)
                            <div class="branch-item p-3 branch-row" data-shop="{{ $branch->shop_id }}" data-shopname="{{ $branch->shop->name ?? 'محل غير معروف' }}">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-store text-primary"></i>
                                        <span class="fw-bold branch-name">{{ $branch->shop->name ?? 'محل غير معروف' }}</span>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-column flex-md-row gap-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-map-pin text-muted me-2"></i>
                                                <span class="text-dark">"{{ $branch->location }}"</span>
                                            </div>
                                            @if(isset($branch->neighborhood) && $branch->neighborhood)
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                                <span class="text-dark">"{{ $branch->neighborhood }}"</span>
                                            </div>
                                            @endif
                                            @if($branch->phone_number)
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-phone text-muted me-2"></i>
                                                <span dir="ltr">{{ $branch->phone_number }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
                                        <div class="branch-actions">
                                            <form action="{{ route('branches.destroy', $branch->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('هل أنت متأكد من حذف هذا الفرع؟')">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span class="d-none d-sm-inline ms-1">حذف</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-map-marker-slash text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">لا توجد فروع مضافة حاليًا</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div id="no-shop-selected-message" class="text-center text-muted py-4" style="display:block;">
                    <i class="fas fa-store-alt fa-2x mb-2"></i><br>
                    يرجى اختيار محل لعرض الفروع الخاصة به
                </div>
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
    var branchMap = L.map('branch-map').setView(gazaStripCenter, 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(branchMap);

    var bounds = L.latLngBounds([31.22, 34.19], [31.60, 34.55]);
    branchMap.setMaxBounds(bounds);
    branchMap.on('drag', function() {
        branchMap.panInsideBounds(bounds, { animate: false });
    });

    setTimeout(() => {
        branchMap.invalidateSize();
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
        if (lat >= 31.53) return "تل الزعتر";
        if (lat >= 31.5) return "الرمال";
        if (lat >= 31.4) return "دير البلح";
        if (lat >= 31.35) return "بني سهيلا";
        return "تل السلطان";
    }

    branchMap.on('click', function(e) {
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

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(branchMap);
        }
        
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                const govMap = {
                    "Gaza": "غزة", "North Gaza": "الشمال", "Khan Yunis": "خانيونس", "Rafah": "رفح",
                    "Deir al-Balah": "الوسطى", "Deir al Balah": "الوسطى", "Deir Al Balah": "الوسطى", "Gaza Strip": "غزة"
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
                
                var branchForm = document.getElementById('add-branch-form');
                branchForm.querySelector('#branch-latitude').value = lat;
                branchForm.querySelector('#branch-longitude').value = lng;
                branchForm.querySelector('#branch-governorate').value = gov;
                branchForm.querySelector('#branch-neighborhood').value = neigh;
                
                const mapContainer = document.querySelector('.map-container');
                let oldMsg = mapContainer.querySelector('.location-success-msg');
                if (oldMsg) oldMsg.remove();
                const msg = document.createElement('div');
                msg.className = 'alert alert-success location-success-msg';
                msg.style.position = 'absolute';
                msg.style.top = '10px';
                msg.style.right = '10px';
                msg.style.zIndex = '1200';
                msg.innerHTML = `<i class=\"fas fa-check-circle me-2\"></i>تم تحديد الموقع بنجاح في ${gov} - ${neigh}`;
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
                
                var branchForm = document.getElementById('add-branch-form');
                branchForm.querySelector('#branch-latitude').value = lat;
                branchForm.querySelector('#branch-longitude').value = lng;
                branchForm.querySelector('#branch-governorate').value = gov;
                branchForm.querySelector('#branch-neighborhood').value = neigh;
            });
    });

    var branchForm = document.getElementById('add-branch-form');
    branchForm.addEventListener('submit', function(e) {
        var lat = branchForm.querySelector('#branch-latitude').value;
        var lng = branchForm.querySelector('#branch-longitude').value;
        var gov = branchForm.querySelector('#branch-governorate').value;
        var neigh = branchForm.querySelector('#branch-neighborhood').value;
        
        if (!lat || !lng || !gov || !neigh) {
            e.preventDefault();
            alert('يجب تحديد الموقع والمحافظة والحي قبل حفظ الفرع.');
        }
    });

    // Filter branches by shop
    const shopSelect = document.getElementById('shop_id');
    const branchItems = document.querySelectorAll('.branch-row');
    function filterBranches(selector) {
        const selectedShop = selector.value;
        const branchesSection = document.getElementById('branches-section');
        const branchesList = document.getElementById('branches-list');
        const noShopMsg = document.getElementById('no-shop-selected-message');
        const heading = document.getElementById('branches-heading');
        const shopTitle = document.getElementById('branches-shop-title');
        if (!selectedShop) {
            branchesSection.style.display = 'none';
            noShopMsg.style.display = 'block';
            return;
        }
        let selectedShopName = '';
        const selectedOption = shopSelect.options[shopSelect.selectedIndex];
        selectedShopName = selectedOption ? selectedOption.text : '';
        shopTitle.textContent = `الفروع التابعة لمحل "${selectedShopName}"`;
        let anyVisible = false;
        branchItems.forEach(function(item) {
            const itemShopId = item.getAttribute('data-shop');
            if (itemShopId === selectedShop) {
                item.style.display = '';
                anyVisible = true;
            } else {
                item.style.display = 'none';
            }
        });
        branchesSection.style.display = anyVisible ? '' : 'none';
        noShopMsg.style.display = anyVisible ? 'none' : 'block';
    }
    document.getElementById('branches-section').style.display = 'none';
    document.getElementById('no-shop-selected-message').style.display = 'block';
    shopSelect.addEventListener('change', function() {
        filterBranches(this);
    });
});
</script>
@endsection