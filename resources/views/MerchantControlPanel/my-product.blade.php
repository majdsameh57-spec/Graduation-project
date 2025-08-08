@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - منتجاتي')
@section('page_title', 'منتجاتي')

@section('breadcrumb')
    <li class="breadcrumb-item active">إدارة المنتجات</li>
@endsection

@section('styles')
<style>
    .dashboard-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,71,179,0.07);
        border: 1px solid #e3f2fd;
        padding: 20px;
        margin-bottom: 2rem;
    }
    .main-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0047b3;
        margin-bottom: 1.5rem;
    }
    .product-card {
        background-color: #f8fafc;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,71,179,0.07);
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,71,179,0.1);
        transform: translateY(-2px);
    }
    .product-image {
        width: 100%;
        height: 210px;
        background-color: #f8fafc;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .badge {
        display: inline-block;
        padding: 0.3em 0.8em;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        background-color: #e3f2fd;
        color: #0047b3;
        margin-bottom: 0.5em;
        margin-left: 4px;
        border: 1px solid #b6d4fe;
    }
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0047b3;
        margin-bottom: 0.3em;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .product-desc {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 0.5em;
        min-height: 40px;
    }
    .product-price {
        color: #198754;
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 0.5em;
    }
    .location-list {
        margin-bottom: 0.5em;
    }
    .location-list .badge {
        background-color: #e3f2fd;
        color: #0047b3;
        font-size: 0.85rem;
        margin-bottom: 2px;
    }
    .payment-list {
        margin-top: 0.5em;
        font-size: 0.9rem;
        color: #0e7490;
    }
    .action-btns {
        display: flex;
        gap: 0.5em;
        margin-top: 1.2em;
    }
    .btn-primary {
        background-color: #0047b3;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.5em 1.2em;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,71,179,0.07);
    }
    .btn-primary:hover {
        background-color: #003a8c;
        transform: translateY(-2px);
    }
    .btn-danger {
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.5em 1.2em;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-danger:hover {
        background-color: #bb2d3b;
        transform: translateY(-2px);
    }
    .empty-state {
        text-align: center;
        padding: 30px 0;
    }
    .empty-state-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }
    @media (max-width: 767.98px) {
        .dashboard-card { 
            padding: 15px;
        }
        .product-image { 
            height: 180px; 
        }
        .action-btns {
            width: 100%;
            justify-content: space-between;
        }
    }
    @media (max-width: 576px) {
        .dashboard-card { 
            padding: 10px; 
        }
        .main-title { 
            font-size: 1.3rem; 
        }
        .product-image { 
            height: 140px; 
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
                        <i class="fas fa-box"></i>
                        <span class="card-title m-0">قائمة المنتجات</span>
                    </div>
                    <div>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>
                            إضافة منتج جديد
                        </a>
                    </div>
                </div>
                
                <div class="row g-4">
                    @forelse ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card h-100">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-image">
                                <div class="p-3 d-flex flex-column h-100">
                                    <div class="product-title mb-2">
                                        <i class="fas fa-box-open text-primary"></i>
                                        {{ $product->name }}
                                    </div>
                                    <div class="product-desc">{{ $product->description }}</div>
                                    <div class="product-price">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $product->price }} شيكل
                                    </div>
                                    {{-- أماكن تواجد المنتج --}}
                                    <div class="location-list mb-2">
                                        <strong class="text-dark">
                                            <i class="fas fa-map-marker-alt text-secondary me-1"></i>
                                            أماكن تواجد المنتج:
                                        </strong>
                                        <div class="mt-2">
                                            {{-- المحل الرئيسي --}}
                                            @if($product->shop)
                                                <span class="badge">
                                                    <i class="fas fa-store me-1"></i>
                                                    {{ $product->shop->name }}
                                                    @if($product->shop->branches && $product->shop->branches->count())
                                                        <span style="font-size:0.9em;">(رئيسي)</span>
                                                    @endif
                                                </span>
                                            @endif
                                            {{-- الفروع --}}
                                            @if($product->branches && $product->branches->count())
                                                @php
                                                    $ordinals = ['الأول','الثاني','الثالث','الرابع','الخامس','السادس','السابع','الثامن','التاسع','العاشر'];
                                                @endphp
                                                @foreach($product->branches as $i => $branch)
                                                    <span class="badge">
                                                        <i class="fas fa-code-branch me-1"></i>
                                                        {{ $branch->shop->name }}
                                                        <span style="font-size:0.9em;">
                                                            (الفرع {{ $ordinals[$i] ?? 'رقم ' . ($i+1) }})
                                                        </span>
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @if ($product->paymentMethods && $product->paymentMethods->count())
                                        <div class="payment-list">
                                            <strong class="text-dark">
                                                <i class="fas fa-credit-card text-secondary me-1"></i>
                                                طرق الدفع:
                                            </strong>
                                            <ul class="list-unstyled mt-1 mb-0">
                                                @foreach ($product->paymentMethods as $method)
                                                    <li>
                                                        <i class="fas fa-{{ $method->is_online ?? false ? 'credit-card' : 'money-bill-wave' }} me-1"></i>
                                                        {{ $method->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="action-btns mt-auto">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit me-1"></i>
                                            تعديل
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-product-btn">
                                                <i class="fas fa-trash-alt me-1"></i>
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h5>لا توجد منتجات</h5>
                                <p class="text-muted">لم تقم بإضافة أي منتجات بعد</p>
                                <a href="{{ route('products.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    إضافة منتج جديد
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    document.querySelectorAll('.delete-product-btn').forEach(function(btn) {
        btn.closest('form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف المنتج بشكل نهائي!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.closest('form').submit();
                }
            });
        });
    });

    const status = @json(session('status'));
    const icon = @json(session('icon'));
    const message = @json(session('message'));
    if (status) {
        Toast.fire({
            icon: icon || 'success',
            title: message
        });
    }
    @if ($errors->any())
        let errorMessages = {!! json_encode($errors->all()) !!};
        Toast.fire({
            icon: 'error',
            title: 'يوجد خطأ',
            html: errorMessages.join('<br>')
        });
    @endif
});
</script>
@endsection