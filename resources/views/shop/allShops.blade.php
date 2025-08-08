@extends('Liquidity.parent')
@section('title', 'عرض المحلات')

@section('styles')
    <style>
        .search-section {
            background-color: #fff;
            border-radius: 16px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }
        
        @media (max-width: 768px) {
            .search-section {
                padding: 20px;
                margin-top: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .search-section {
                padding: 15px;
                margin-top: 15px;
            }
        }
        .store-card {
            background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%);
            border-radius: 22px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.09);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.8rem 1.2rem 1.2rem 1.2rem;
            min-height: 440px;
            transition: box-shadow 0.3s, transform 0.3s;
            height: 100%;
        }
        .store-card:hover {
            box-shadow: 0 16px 48px 0 rgba(0,71,179,0.18), 0 2px 12px 0 rgba(0,0,0,0.10);
            transform: translateY(-6px) scale(1.03);
        }
        .store-card img {
            border-radius:50%;
            width:170px;
            height:170px;
            object-fit:cover;
            box-shadow:0 4px 16px rgba(0,0,0,0.11);
            border:6px solid #fff;
            margin-bottom:22px;
            background: #fff;
        }
        .shop-title {
            text-align:center;
            font-size:1.25rem;
            font-weight:bold;
            color:#0054d7;
            margin-bottom:6px;
        }
        .shop-desc {
            text-align:center;
            margin-bottom:8px;
        }
        .badge-location {
            background: none;
            font-size: 0.97rem;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            line-height: 1;
        }
        .badge-location i {
            flex-shrink: 0;
            font-size: 1.2rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }
        .shop-contact {
            text-align:center;
            color:#0054d7;
            font-size:1rem;
            margin-bottom:2px;
        }
        .btn-outline-primary {
            border-radius: 14px;
            font-weight: 700;
            font-size: 1.08rem;
            padding: 0.7rem 1.7rem;
            margin-top: 14px;
        }
        #searchInput {
            max-width: 400px;
            padding-left: 2.5rem;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.15);
            background: url('data:image/svg+xml;utf8,<svg fill="%230d6efd" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"><path d="M11.742 10.344a6.5 6.5 0 111.397-1.398h-.001l3.85 3.85-1.397 1.398-3.85-3.85zm-5.242.656a5 5 0 100-10 5 5 0 000 10z"/></svg>') no-repeat 10px center;
            background-size: 16px 16px;
        }
        
        @media (max-width: 992px) {
            .store-card {
                min-height: 400px;
            }
            
            .store-card img {
                width: 150px;
                height: 150px;
            }
            
            .shop-title {
                font-size: 1.15rem;
            }
        }
        
        @media (max-width: 768px) {
            .store-card {
                min-height: 380px;
                padding: 1.5rem 1rem 1rem 1rem;
            }
            
            .store-card img {
                width: 130px;
                height: 130px;
                margin-bottom: 18px;
            }
            
            .btn-outline-primary {
                padding: 0.6rem 1.4rem;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .store-card {
                min-height: 340px;
                padding: 1.2rem 0.8rem 0.8rem 0.8rem;
            }
            
            .store-card img {
                width: 120px;
                height: 120px;
                margin-bottom: 15px;
                border-width: 4px;
            }
            
            .shop-title {
                font-size: 1.1rem;
            }
            
            .shop-desc .badge-location {
                font-size: 0.9rem;
                padding: 4px 10px;
            }
            
            .shop-contact {
                font-size: 0.9rem;
            }
            
            .btn-outline-primary {
                padding: 0.5rem 1.2rem;
                font-size: 0.95rem;
                margin-top: 10px;
            }
        }
        #noResults {
            text-align: center;
            color: #888;
            font-weight: 500;
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <h2 class="fw-bold text-primary">عرض المحلات</h2>
        </div>

        <div class="search-section mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-12">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="ابحث عن محل..."
                        class="form-control" autocomplete="off" />
                </div>
                <div class="col-md-4 col-12">
                    <select id="governorateFilter" class="form-select" onchange="updateNeighborhoods(); filterTable();">
                        <option value="">كل المحافظات</option>
                        @foreach($governorates as $gov)
                            <option value="{{ $gov }}">{{ $gov }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <select id="neighborhoodFilter" class="form-select" onchange="filterTable()">
                        <option value="">كل الأحياء</option>
                        {{-- الأحياء ستملأ ديناميكياً بالسكريبت --}}
                    </select>
                </div>
            </div>
        </div>
        <div id="noResults">لا يوجد محل مطابق للبحث.</div>

        <div class="row g-4 mt-4">
            @foreach ($shops as $shop)
                @php
                    $branches = $shop->branches;
                    $branchesCount = $branches->count();
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
                    $gov = $shop->location->governorate ?? '';
                    $neigh = $shop->location->neighborhood ?? '';
                @endphp

                @if($branchesCount == 0)
                    {{-- بطاقة المحل بدون فروع (تصميم احترافي) --}}
                    <div class="col-lg-3 col-md-4 col-sm-6 card-container"
                         data-gov="{{ $shop->location->governorate ?? '' }}"
                         data-neighborhood="{{ $shop->location->neighborhood ?? '' }}">
                        <div class="store-card">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}">
                            <div class="shop-title">
                                <h5 style="all:unset; display:inline; font-size:inherit; font-weight:inherit; color:inherit;">
                                    <i class="fas fa-store-alt me-2 text-dark"></i>
                                    {{ $shop->name }}
                                </h5>
                            </div>
                            <div class="shop-desc">
                                <span class="badge-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $shop->location->governorate ?? '' }} - {{ $shop->location->neighborhood ?? '' }}</span>
                                </span>
                            </div>
                            @if($shop->phone)
                                <div class="shop-contact mb-1" style="text-align:center; color:#0054d7; font-size:1rem;">
                                    <i class="bi bi-telephone"></i> {{ $shop->phone }}
                                </div>
                            @endif
                            <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-outline-primary mt-auto px-4 py-2 fw-bold" style="border-radius: 12px; margin-top: 12px;">
                                <i class="fas fa-info-circle me-1"></i> عرض التفاصيل
                            </a>
                        </div>
                    </div>
                @else
                    {{-- بطاقة المحل كفرع رئيسي (تصميم موحد) --}}
                    <div class="col-lg-3 col-md-4 col-sm-6 card-container"
                         data-gov="{{ $gov }}"
                         data-neighborhood="{{ $neigh }}">
                        <div class="store-card">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}">
                            <div class="shop-title">
                                <h5 style="all:unset; display:inline; font-size:inherit; font-weight:inherit; color:inherit;">
                                    <i class="fas fa-store-alt me-2 text-dark"></i>
                                    {{ $shop->name }}
                                </h5>
                                <span class="text-muted fs-6 ms-1">(الفرع الرئيسي)</span>
                            </div>
                            <div class="shop-desc">
                                <span class="badge-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $shop->location->governorate ?? '' }} - {{ $shop->location->neighborhood ?? '' }}</span>
                                </span>
                            </div>
                            @if($shop->phone)
                                <div class="shop-contact">
                                    <i class="bi bi-telephone"></i> {{ $shop->phone }}
                                </div>
                            @endif
                            <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-outline-primary mt-auto">
                                <i class="fas fa-info-circle me-1"></i> عرض التفاصيل
                            </a>
                        </div>
                    </div>
                    {{-- بطاقات الفروع --}}
                    @foreach($branches as $index => $branch)

                        <div class="col-lg-3 col-md-4 col-sm-6 card-container"
                        data-gov="{{ $branch->locationRelation->governorate ?? '' }}"
                        data-neighborhood="{{ $branch->locationRelation->neighborhood ?? '' }}">
                            <div class="store-card">
                                <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}">
                                <div class="shop-title">
                                    <h5 style="all:unset; display:inline; font-size:inherit; font-weight:inherit; color:inherit;">
                                        <i class="fas fa-store-alt me-2 text-dark"></i>
                                        {{ $branch->name ?? $shop->name }}
                                    </h5>
                                    <span class="text-muted fs-6 ms-1">(الفرع {{ $ordinalArabic[$index+1] ?? 'رقم ' . ($index+1) }})</span>
                                </div>
                                <div class="shop-desc">
                                    <span class="badge-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $branch->location ?? '' }}</span>
                                    </span>
                                </div>
                                @if(!empty($branch->address_details))
                                    <p class="text-muted small mb-0">{{ Str::limit($branch->address_details, 50) }}</p>
                                @endif
                                @if($branch->phone_number)
                                    <div class="shop-contact">
                                        <i class="bi bi-telephone"></i> {{ $branch->phone_number }}
                                    </div>
                                @endif
                                <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-outline-primary mt-auto">
                                    <i class="fas fa-info-circle me-1"></i> عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script>
const neighborhoodsData = @json($neighborhoods);

function updateNeighborhoods() {
    const gov = document.getElementById("governorateFilter").value;
    const neighborhoodSelect = document.getElementById("neighborhoodFilter");
    neighborhoodSelect.innerHTML = '<option value="">كل الأحياء</option>';
    if (gov && neighborhoodsData[gov]) {
        neighborhoodsData[gov].forEach(function(n) {
            neighborhoodSelect.innerHTML += `<option value="${n}">${n}</option>`;
        });
    }
}

function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const gov = document.getElementById("governorateFilter").value;
    const neighborhood = document.getElementById("neighborhoodFilter").value;
    const cards = document.querySelectorAll('.card-container');
    let visibleCount = 0;

    cards.forEach(container => {
        const name = container.querySelector('h5').textContent.toLowerCase();
        const shopGov = container.getAttribute('data-gov');
        const shopNeighborhood = container.getAttribute('data-neighborhood');

        let show = true;

        if (input && !name.includes(input)) show = false;

        if (gov && shopGov !== gov) show = false;

        if (neighborhood && shopNeighborhood !== neighborhood) show = false;

        container.style.display = show ? "" : "none";
        if (show) visibleCount++;
    });

    document.getElementById("noResults").style.display = (visibleCount === 0) ? "block" : "none";
}
</script>
@endsection