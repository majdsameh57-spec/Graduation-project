@extends('Liquidity.parent')
@section('title', 'تفاصيل الفرع')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            background: linear-gradient(120deg, #e3f2fd 0%, #f8fafc 100%);
        }
        .shop-header {
            background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%);
            border-radius: 22px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.09);
            padding: 40px 32px 32px 32px;
            margin-bottom: 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: flex-start;
        }
        .shop-media {
            display: flex;
            flex-direction: column;
            gap: 22px;
            min-width: 340px;
            max-width: 360px;
        }
        .shop-header img {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.11);
            width: 100%;
            height: 230px;
            object-fit: cover;
            border: 5px solid #fff;
            transition: 0.3s;
        }
        .shop-header img:hover {
            transform: scale(1.03) rotate(-1deg);
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
        }
        #shop-map {
            height: 230px;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.11);
            width: 100%;
            border: 2px solid #e3f2fd;
        }
        .shop-info {
            flex: 1;
            min-width: 220px;
            margin-top: 10px;
        }
        .shop-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0054d7;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .shop-location {
            font-size: 1.15rem;
            color: #198754;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .shop-desc {
            color: #555;
            margin-bottom: 18px;
            font-size: 1.08rem;
        }
        .shop-contact {
            font-size: 1rem;
            color: #0054d7;
            margin-bottom: 6px;
        }
        .products-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #0054d7;
            margin-bottom: 22px;
            letter-spacing: 1px;
        }
        .product-card {
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            transition: 0.2s;
            background: #fff;
            border: 1.5px solid #e3f2fd;
        }
        .product-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            transform: translateY(-6px) scale(1.03);
            border-color: #90caf9;
        }
        .product-card .card-img-top {
            border-radius: 16px 16px 0 0;
            height: 170px;
            object-fit: cover;
            background: #f8fafc;
        }
        .product-card .card-title {
            color: #0054d7;
            font-size: 1.18rem;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .product-card .product-price {
            color: #198754;
            font-weight: bold;
            font-size: 1.08rem;
            margin-bottom: 6px;
        }
        .payment-list {
            margin-top: 8px;
            font-size: 0.97rem;
        }
        .payment-list strong {
            color: #0054d7;
        }
        .badge {
            background: #e3f2fd;
            color: #0054d7;
            font-size: 0.95rem;
            border-radius: 8px;
            padding: 4px 10px;
            margin-right: 4px;
        }
        .leaflet-control-attribution {
            display: none !important;
        }

        .leaflet-tile {
            border: none !important;
        }

        .leaflet-marker-icon,
        .leaflet-marker-shadow,
        .leaflet-popup-tip-container,
        .leaflet-popup-tip,
        .leaflet-marker-icon.leaflet-interactive {
            background: none !important;
            box-shadow: none !important;
            filter: none !important;
            border: none !important;
            border-radius: 0 !important;
        }

        .leaflet-marker-shadow {
            display: none !important;
        }

        @media (max-width: 900px) {
            .shop-header { flex-direction: column; align-items: stretch; }
            .shop-media { max-width: 100%; min-width: 0; flex-direction: row; gap: 18px; }
            #shop-map, .shop-header img { height: 180px; }
        }
        @media (max-width: 600px) {
            .shop-title { font-size: 1.3rem; }
            .products-title { font-size: 1.1rem; }
        }
    </style>
@endsection

@section('content')
<div class="container py-5">
<div class="shop-header mb-4" style="display: flex; flex-direction: row; gap: 40px; align-items: stretch;">
    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $branch->name ?? $shop->name }}"
             style="border-radius:50%; width:170px; height:170px; object-fit:cover; box-shadow:0 4px 16px rgba(0,0,0,0.11); border:6px solid #fff; margin-bottom:22px;">
@php
    // ترتيب الفرع بين الفروع
    $ordinalArabic = [
        1 => 'الأول',
        2 => 'الثاني',
        3 => 'الثالث',
        4 => 'الرابع',
        5 => 'الخامس',
        6 => 'السادس',
        7 => 'السابع',
        8 => 'الثامن',
        9 => 'التاسع',
        10 => 'العاشر',
    ];
    // إيجاد رقم الفرع الحالي بين فروع المحل
    $branchIndex = $shop->branches->search(function($b) use ($branch) {
        return $b->id == $branch->id;
    });
@endphp

<div class="shop-title" style="text-align:center;">
    <i class="fas fa-store-alt me-2 text-dark"></i>
    {{ $branch->name ?? $shop->name }}
    <span class="text-muted fs-6 ms-1">
        (الفرع {{ $ordinalArabic[$branchIndex+1] ?? 'رقم ' . ($branchIndex+1) }})
    </span>
</div>        <div class="shop-desc" style="text-align:center;">
            <span class="badge-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $branch->location }}</span>
            </span>
        </div>
        @if($branch->address_details)
            <div class="shop-desc" style="text-align:center;">
                {{ Str::limit($branch->address_details, 50) }}
            </div>
        @endif
        @if($branch->phone_number)
            <div class="shop-contact" style="text-align:center;"><i class="bi bi-telephone"></i> {{ $branch->phone_number }}</div>
        @endif
    </div>
    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div style="font-weight:bold; color:#0054d7; font-size:1.15rem; margin-bottom:12px;">
            🗺️ موقع الفرع على الخريطة
        </div>
        <div id="shop-map" style="height:400px; width:100%; max-width:500px; border-radius:28px; box-shadow:0 4px 24px rgba(0,0,0,0.13); border:2px solid #e3f2fd;"></div>
    </div>
</div>

    <div class="products-title">🛒 المنتجات المتوفرة في هذا الفرع:</div>
    @if ($branch->products && $branch->products->isEmpty())
        <p class="text-muted">لا توجد منتجات مرتبطة بهذا الفرع.</p>
    @elseif($branch->products)
        <div class="row g-4">
            @foreach ($branch->products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                            <div class="product-price">{{ $product->price }} شيكل</div>
                            @if ($product->paymentMethods && $product->paymentMethods->count())
                                <div class="payment-list">
                                    <strong>طرق الدفع:</strong>
                                    <ul class="list-unstyled mt-1 mb-0">
                                        @foreach ($product->paymentMethods as $method)
                                            <li>💳 {{ $method->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @auth
                            <button class="btn btn-success mt-3 add-to-cart-btn" 
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->price }}"
                                data-product-image="{{ $product->image }}"
                                data-shop-id="{{ $shop->id }}"
                                data-shop-name="{{ $shop->name }}"
                                data-branch-name="{{ $branch->name ?? $shop->name }}"
                                data-card-title="{{ ($branch->name ?? $shop->name) }} <span class='text-muted fs-6 ms-1'>(الفرع {{ isset($ordinalArabic[$branchIndex+1]) ? $ordinalArabic[$branchIndex+1] : 'رقم ' . ($branchIndex+1) }})</span>"
                                style="width:100%; font-weight:bold; font-size:1.08rem; box-shadow:0 2px 8px rgba(0,84,215,0.07); border-radius:10px; letter-spacing:0.5px;"
                            >
                                <i class="fas fa-cart-plus me-1"></i> أضف إلى السلة
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var lat = {{ $branch->latitude ?? '31.5' }};
    var lng = {{ $branch->longitude ?? '34.47' }};
    var map = L.map('shop-map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    var customIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: '', 
        shadowSize: [0, 0],
        shadowAnchor: [0, 0]
    });

    L.marker([lat, lng], { icon: customIcon }).addTo(map)
        .bindPopup('موقع الفرع هنا')
        .openPopup();

    document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var product = {
                id: this.dataset.productId,
                name: this.dataset.productName,
                price: this.dataset.productPrice,
                image: this.dataset.productImage,
                shop_id: this.dataset.shopId,
                shop_name: this.dataset.shopName,
                branch_name: (this.dataset.cardTitle ? this.dataset.cardTitle.replace(/<[^>]+>/g, '') : (this.dataset.branchName || '')),
                quantity: 1
            };
            var cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart.length > 0) {
                var currentShopId = cart[0].shop_id;
                if (product.shop_id != currentShopId) {
                    if (window.Toast) {
                        Toast.fire({
                            icon: 'error',
                            title: 'لا يمكنك إضافة منتجات من أكثر من متجر في نفس السلة. يجب إتمام الطلب أو إفراغ السلة أولاً.',
                        });
                    } else {
                        alert('لا يمكنك إضافة منتجات من أكثر من متجر في نفس السلة. يجب إتمام الطلب أو إفراغ السلة أولاً.');
                    }
                    return;
                }
            }
            var existing = cart.find(function(item) { return item.id == product.id; });
            if (existing) {
                existing.quantity += 1;
                if (window.Toast) {
                    Toast.fire({
                        icon: 'success',
                        title: 'تمت زيادة الكمية في السلة',
                    });
                }
            } else {
                cart.push(product);
                if (window.Toast) {
                    Toast.fire({
                        icon: 'success',
                        title: 'تمت إضافة المنتج إلى السلة!',
                    });
                }
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            var cartCount = document.getElementById('cart-count');
            if(cartCount) {
                var total = cart.reduce(function(sum, item) { return sum + item.quantity; }, 0);
                cartCount.textContent = total;
            }
        });
    });

    setTimeout(function () {
        map.invalidateSize();
    }, 500);
});
</script>
@endsection