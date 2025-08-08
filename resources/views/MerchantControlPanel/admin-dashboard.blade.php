@extends('MerchantControlPanel.parent')

@section('title', 'لوحة تحكم المشرف')
@section('page_title', 'لوحة تحكم المشرف')

@section('breadcrumb')
    <li class="breadcrumb-item active">نظرة عامة</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">عدد المحلات </div>
                    <div class="stats-value">{{ $shopsCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
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
        <div class="col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">عدد التجار النشطين</div>
                    <div class="stats-value">{{ $activeMerchantsCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-title">عدد المنتجات الكلية</div>
                    <div class="stats-value">{{ $productsCount }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="dashboard-card h-100">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    <span>عدد المحلات المسجلة لكل شهر</span>
                </h3>
                <div class="chart-container mt-4" style="position: relative; height:300px;">
                    <canvas id="shopsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    <span>آخر النشاطات</span>
                </h3>
                <div class="activities-container mt-3">
                    @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                @if($activity['type'] === 'merchant')
                                    <i class="fas fa-user-plus"></i>
                                @elseif($activity['type'] === 'product')
                                    <i class="fas fa-box"></i>
                                @else
                                    <i class="fas fa-bell"></i>
                                @endif
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">
                                    @if($activity['type'] === 'merchant')
                                        تم إنشاء تاجر جديد: <span class="fw-bold">{{ $activity['name'] }}</span>
                                    @elseif($activity['type'] === 'product')
                                        تم إضافة منتج جديد: <span class="fw-bold">{{ $activity['name'] }}</span>
                                    @endif
                                </div>
                                <div class="activity-time">{{ $activity['created_at']->locale('ar')->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-clock text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mt-2">لا توجد نشاطات حديثة</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
        <div class="row g-4">
        <div class="col-lg-6">
            <div class="dashboard-card h-100">
                <h3 class="card-title">
                    <i class="fas fa-store"></i>
                    <span>أحدث المحلات المسجلة</span>
                </h3>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المحل</th>
                                <th>المالك</th>
                                <th>تاريخ التسجيل</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($recentShops) && count($recentShops) > 0)
                                @foreach($recentShops as $shop)
                                    <tr>
                                        <td class="fw-medium">{{ $shop->name ?? 'محل جديد' }}</td>
                                        <td>{{ $shop->merchant->name ?? 'غير محدد' }}</td>
                                        <td>{{ isset($shop->created_at) ? $shop->created_at->format('Y-m-d') : 'غير محدد' }}</td>
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-3">لا توجد محلات مسجلة حديثاً</td>
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
                    <i class="fas fa-box"></i>
                    <span>أحدث المنتجات المضافة</span>
                </h3>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>المحل</th>
                                <th>السعر</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($recentProducts) && count($recentProducts) > 0)
                                @foreach($recentProducts as $product)
                                    <tr>
                                        <td class="fw-medium">{{ $product->name ?? 'منتج جديد' }}</td>
                                        <td>{{ $product->shop->name ?? 'غير محدد' }}</td>
                                        <td>{{ isset($product->price) ? $product->price : 'غير محدد' }} ₪</td>
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center py-3">لا توجد منتجات مضافة حديثاً</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
    var ctx = document.getElementById('shopsChart').getContext('2d');
    
    var gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(0,161,255,0.18)');
    gradient.addColorStop(0.8, 'rgba(0,161,255,0.01)');
    
    var shopsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($shopsPerMonth['labels']),
            datasets: [{
                label: 'عدد المحلات',
                data: @json($shopsPerMonth['data']),
                backgroundColor: gradient,
                borderColor: '#0066cc',
                borderWidth: 3,
                pointBackgroundColor: '#0047b3',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,71,179,0.9)',
                    titleFont: {
                        family: 'Tajawal',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Tajawal',
                        size: 14
                    },
                    padding: 12,
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
                        color: 'rgba(0,71,179,0.05)',
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
            hover: {
                mode: 'nearest',
                intersect: false
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
