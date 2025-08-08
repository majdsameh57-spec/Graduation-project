@extends('Liquidity.parent')
@section('title', 'تفاصيل المحل - سيولتك')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            background: linear-gradient(120deg, #e3f2fd 0%, #f8fafc 100%);
        }
        .product-card .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-card .add-to-cart-btn {
            margin-top: auto !important;
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
            height: 400px;
            border-radius: 28px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.13);
            width: 100%;
            max-width: 500px;
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
        
        @media (max-width: 992px) {
            .shop-header { 
                flex-direction: column; 
                align-items: stretch;
                padding: 30px 25px 25px 25px;
                gap: 30px;
            }
            .shop-media { 
                max-width: 100%; 
                min-width: 0; 
                flex-direction: row; 
                gap: 18px; 
            }
            #shop-map, .shop-header img { 
                height: 250px; 
            }
            .shop-title {
                font-size: 2.2rem;
            }
            .products-title {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .shop-header {
                padding: 25px 20px 20px 20px;
                margin-bottom: 30px;
                gap: 25px;
            }
            #shop-map, .shop-header img { 
                height: 200px; 
            }
            .shop-title {
                font-size: 1.8rem;
            }
            .products-title {
                font-size: 1.4rem;
                margin-bottom: 18px;
            }
        }
        
        @media (max-width: 576px) {
            .shop-header {
                padding: 20px 15px 15px 15px;
                margin-bottom: 25px;
                gap: 20px;
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .shop-title { 
                font-size: 1.5rem; 
            }
            .products-title { 
                font-size: 1.3rem; 
                margin-bottom: 15px;
            }
            #shop-map, .shop-header img { 
                height: 180px; 
            }
            .shop-location {
                font-size: 1rem;
            }
            .shop-desc {
                font-size: 0.95rem;
                margin-bottom: 15px;
            }
            .product-card .card-img-top {
                height: 140px;
            }
            .product-card .card-title {
                font-size: 1.1rem;
            }
            .product-card .product-price {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="container py-5">
{{-- ...existing code... --}}
<div class="shop-header mb-4" style="display: flex; flex-direction: row; gap: 40px; align-items: stretch;">
    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}"
             style="border-radius:50%; width:170px; height:170px; object-fit:cover; box-shadow:0 4px 16px rgba(0,0,0,0.11); border:6px solid #fff; margin-bottom:22px;">
        
        @php
            $branchesCount = $shop->branches ? $shop->branches->count() : 0;
        @endphp

        <div class="shop-title" style="text-align:center;">
            <i class="fas fa-store-alt me-2 text-dark"></i>
            {{ $shop->name }}
            @if($shop->branches && $shop->branches->count() > 0)
                <span class="text-muted fs-6 ms-1">(الفرع الرئيسي)</span>
            @endif
        </div>
        <div class="shop-desc" style="text-align:center;">
            <span class="badge-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $shop->description }}</span>
            </span>
        </div>
        @if($shop->phone)
            <div class="shop-contact" style="text-align:center;"><i class="bi bi-telephone"></i> {{ $shop->phone }}</div>
        @endif
    </div>
    <div style="flex:1; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div style="font-weight:bold; color:#0054d7; font-size:1.15rem; margin-bottom:12px;">
            🗺️ موقع المحل على الخريطة
        </div>
        <div id="shop-map" style="height:400px; width:100%; max-width:500px; border-radius:28px; box-shadow:0 4px 24px rgba(0,0,0,0.13); border:2px solid #e3f2fd;"></div>
    </div>
</div>

    <div class="products-title">🛒 المنتجات المتوفرة:</div>
    @if ($shop->products->isEmpty())
        <p class="text-muted">لا توجد منتجات مرتبطة بهذا المحل.</p>
    @else
        <div class="row g-4">
            @foreach ($shop->products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100" id="product-{{ $product->id }}">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><i class="fas fa-box-open product-icon"></i> {{ $product->name }}</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                            <div class="product-price"><i class="fas fa-shekel-sign"></i> {{ $product->price }} شيكل</div>
                            @if ($product->paymentMethods->count())
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
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                data-shop="{{ $shop->id }}">
                                <i class="fas fa-cart-plus me-1"></i> أضف للسلة
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
    var lat = {{ $shop->latitude ?? '31.5' }};
    var lng = {{ $shop->longitude ?? '34.47' }};
    var map = L.map('shop-map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var customIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: '',
        shadowSize: [0, 0],
        shadowAnchor: [0, 0]
    });

    L.marker([lat, lng], { icon: customIcon }).addTo(map)
        .bindPopup('موقع المحل هنا')
        .openPopup();

    setTimeout(function () {
        map.invalidateSize();
    }, 500);

    function getCart() {
        return JSON.parse(localStorage.getItem('cart') || '[]');
    }
    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price,
                image: this.dataset.image,
                shop: this.dataset.shop,
                shop_name: (typeof SHOP_NAME !== 'undefined') ? SHOP_NAME : (document.querySelector('.shop-title') ? document.querySelector('.shop-title').textContent.trim() : ''),
                branch_name: '',
                quantity: 1
            };
            var cart = getCart();
            if (cart.length > 0) {
                var currentShopId = cart[0].shop;
                if (product.shop != currentShopId) {
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
            var found = cart.find(p => p.id == product.id && p.shop == product.shop);
            if (found) {
                found.quantity += 1;
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
            setCart(cart);
            this.innerHTML = '<i class="fas fa-check"></i> تمت الإضافة';
            this.classList.remove('btn-success');
            this.classList.add('btn-secondary');
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-cart-plus me-1"></i> أضف للسلة';
                this.classList.remove('btn-secondary');
                this.classList.add('btn-success');
            }, 1200);
        });
    });
});
</script>
@endsection