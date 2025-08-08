@extends('MerchantControlPanel.parent')

@section('title', 'لوحة تحكم التاجر')
@section('page_title', 'لوحة تحكم التاجر')

@section('breadcrumb')
    <li class="breadcrumb-item active">نظرة عامة</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">عدد المحلات</div>
                    <div class="stats-value">{{ $shopsCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-code-branch"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">عدد الفروع</div>
                    <div class="stats-value">{{ $branchesCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">إجمالي المنتجات</div>
                    <div class="stats-value">{{ $productsCount }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    <span>المنتجات لكل محل</span>
                </h3>
                <div class="chart-container mt-4" style="position: relative; height:300px;">
                    <canvas id="productsPerShopChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="dashboard-card h-100">
                <h3 class="card-title">
                    <i class="fas fa-store"></i>
                    <span>المحلات</span>
                </h3>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>اسم المحل</th>
                                <th>عدد الفروع</th>
                                <th>عدد المنتجات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($shops) && count($shops) > 0)
                                @foreach($shops as $shop)
                                    <tr>
                                        <td class="fw-medium">{{ $shop->name ?? 'محل جديد' }}</td>
                                        <td>{{ $shop->branches_count ?? 0 }}</td>
                                        <td>{{ $shop->products_count ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-3">لا توجد محلات مسجلة</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="dashboard-card h-100">
                <h3 class="card-title">
                    <i class="fas fa-code-branch"></i>
                    <span>الفروع</span>
                </h3>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>اسم الفرع</th>
                                <th>اسم المحل</th>
                                <th>العنوان</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($branches) && count($branches) > 0)
                                @foreach($branches as $branch)
                                    <tr>
                                        <td class="fw-medium">{{ $branch->name ?? 'فرع جديد' }}</td>
                                        <td class="fw-medium">{{ $branch->name ?? $branch->shop_name }}</td>
                                        <td>{{ $branch->location ?? 'غير محدد' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-3">لا توجد فروع مسجلة</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <h3 class="card-title">
                    <i class="fas fa-box"></i>
                    <span>ملخص المنتجات</span>
                </h3>
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="small text-muted mb-2">متوسط عدد المنتجات لكل محل</div>
                            <div class="fs-4 fw-bold">{{ $averageProductsPerShop }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="small text-muted mb-2">المحل الأكثر منتجات</div>
                            <div class="fs-4 fw-bold">{{ $topShopByProducts->name ?? 'لا يوجد' }}</div>
                            <div class="small">{{ $topShopByProducts->products_count ?? 0 }} منتج</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('productsPerShopChart').getContext('2d');

    var gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(0,161,255,0.6)');
    gradient.addColorStop(1, 'rgba(0,161,255,0.1)');

    var productsPerShopChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($productsPerShop['labels']),
            datasets: [{
                label: 'عدد المنتجات',
                data: @json($productsPerShop['data']),
                backgroundColor: gradient,
                borderColor: '#0099ff',
                borderWidth: 2,
                borderRadius: 6, 
                barPercentage: 0.6,
                categoryPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,71,179,0.95)',
                    titleFont: {
                        family: 'Tajawal',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Tajawal',
                        size: 14
                    },
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: 'Tajawal',
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Tajawal',
                            size: 12
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>


@endsection