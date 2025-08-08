@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - عرض المحلات')
@section('page_title', 'عرض المحلات')

@section('breadcrumb')
    <li class="breadcrumb-item active">عرض المحلات وفروعها ومنتجاتها</li>
@endsection

@section('styles')
<style>
    .dashboard-card {
        background: #fff;
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
    .shop-card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,71,179,0.07);
        border: 1px solid #e3f2fd;
        background: #fff;
        transition: all 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .shop-card:hover {
        box-shadow: 0 4px 12px rgba(0,71,179,0.1);
        transform: translateY(-2px);
    }
    .shop-card .card-img-top {
        height: 180px;
        object-fit: cover;
        background: #f8fafc;
        border-radius: 8px 8px 0 0;
    }
    .shop-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0047b3;
        margin-bottom: 8px;
    }
    .branch-card {
        background-color: #f8fafc;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        border: 1px solid #e9ecef;
        padding: 12px;
    }
    .branch-card:hover {
        box-shadow: 0 4px 12px rgba(0,71,179,0.1);
        transform: translateY(-2px);
    }
    .branch-card .branch-title {
        font-weight: 600;
        color: #0047b3;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .branch-card .branch-location {
        font-size: 0.95rem;
        color: #198754;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .branch-badge, .product-location-badge {
        background-color: #e3f2fd;
        color: #0047b3;
        font-size: 0.85rem;
        border-radius: 6px;
        padding: 4px 10px;
        margin-bottom: 4px;
        display: inline-block;
        border: 1px solid #b6d4fe;
    }
    .product-location-badge {
        font-size: 0.8rem;
        padding: 2px 6px;
        margin-left: 4px;
        margin-bottom: 0;
    }
    .product-list {
        margin-top: 10px;
    }
    .product-list li {
        border-radius: 8px;
        margin-bottom: 4px;
        background: #f8fafc;
        border: 1px solid #e3f2fd;
        transition: all 0.2s ease;
    }
    .product-list li:hover {
        background-color: #f0f7ff;
        border-color: #b6d4fe;
    }
    .delete-btn {
        color: #fff !important;
        background-color: #dc3545;
        border: none;
        border-radius: 6px;
        padding: 3px 10px;
        font-size: 0.85rem;
        margin-right: 5px;
        transition: 0.2s;
    }
    .delete-btn:hover {
        background-color: #bb2d3b;
    }
    @media (max-width: 767.98px) {
        .dashboard-card { padding: 15px; }
        .main-title { font-size: 1.3rem; }
        .branch-actions { 
            width: 100%; 
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    }
    @media (max-width: 576px) {
        .dashboard-card { padding: 10px; }
        .main-title { font-size: 1.2rem; }
        .shop-title { font-size: 1rem; }
        .shop-card .card-img-top { height: 140px; }
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
                        <i class="fas fa-store-alt" style="color: #0047b3;"></i>
                        <span class="card-title m-0">المحلات وفروعها ومنتجاتها</span>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse ($shops as $shop)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card shop-card h-100">
                                <img src="{{ asset('storage/' . $shop->image) }}" class="card-img-top"
                                    alt="{{ $shop->name }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="shop-title mb-2">
                                        <i class="fas fa-store-alt me-2" style="color: #0047b3;"></i>
                                        {{ $shop->name }}
                                    </div>
                                    {{-- فروع المحل --}}
                                    @if($shop->branches->count())
                                        <div class="mb-2">
                                            <div class="fw-bold text-secondary mb-1">الفروع:</div>
                                            @foreach ($shop->branches as $index => $branch)
                                                <div class="branch-card">
                                                    <div class="branch-title">
                                                        <i class="fas fa-code-branch me-1" style="color: #0047b3;"></i>
                                                        {{ $branch->name ?? $shop->name }}
                                                        <span class="text-muted fs-7 ms-1">
                                                            (الفرع {{ $index+1 }})
                                                        </span>
                                                    </div>
                                                    <div class="branch-location">
                                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                                        {{ $branch->location }}
                                                    </div>
                                                    {{-- منتجات الفرع --}}
                                                    @if($branch->products->count())
                                                        <div class="mt-2">
                                                            <span class="fw-bold text-dark">منتجات الفرع:</span>
                                                            <ul class="list-group product-list list-group-flush small">
                                                                @foreach ($branch->products as $product)
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span>
                                                                            <i class="fas fa-box-open text-secondary me-1"></i>
                                                                            {{ $product->name }}
                                                                            <span class="product-location-badge">فرع</span>
                                                                        </span>
                                                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" class="branch-product-delete-form">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                                                            <button type="button" class="delete-btn branch-product-delete-btn">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                                <span class="d-none d-sm-inline ms-1">حذف</span>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <span class="branch-badge">
                                                <i class="fas fa-info-circle me-1"></i>
                                                بدون فروع
                                            </span>
                                        </div>
                                    @endif

                                    <hr class="my-2">

                                    <div class="fw-bold text-dark mb-2">
                                        <i class="fas fa-shopping-cart me-1" style="color: #0047b3;"></i>
                                        منتجات المحل الرئيسي:
                                    </div>
                                    @php
                                        $mainProducts = $shop->products;
                                    @endphp
                                    @if ($mainProducts->isEmpty())
                                        <p class="text-muted mb-0">لا توجد منتجات مرتبطة بهذا المحل.</p>
                                    @else
                                        <ul class="list-group product-list list-group-flush small">
                                            @foreach ($mainProducts as $product)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-box text-secondary me-1"></i>
                                                        {{ $product->name }}
                                                        <span class="product-location-badge">رئيسي</span>
                                                    </span>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" class="main-product-delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                                        <button type="button" class="delete-btn main-product-delete-btn">
                                                            <i class="fas fa-trash-alt"></i>
                                                            <span class="d-none d-sm-inline ms-1">حذف</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-store-slash fa-2x mb-2"></i>
                                <p class="m-0">لا توجد محلات لعرضها حالياً.</p>
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
    function handleDeleteBtn(btnClass, confirmText) {
        document.querySelectorAll(btnClass).forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                var form = btn.closest('form');
                Swal.fire({
                    title: 'تأكيد الحذف',
                    text: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        var formData = new FormData(form);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var res = {};
                                try { res = JSON.parse(xhr.responseText); } catch(e){}
                                Toast.fire({
                                    icon: res.success ? 'success' : 'error',
                                    title: res.success ? 'تم حذف المنتج بنجاح' : 'فشل الحذف'
                                });
                                if(res.success) setTimeout(function(){ location.reload(); }, 900);
                            } else {
                                Toast.fire({ icon: 'error', title: 'فشل الحذف' });
                            }
                        };
                        xhr.send(formData);
                    }
                });
            });
        });
    }
    handleDeleteBtn('.main-product-delete-btn', 'هل أنت متأكد من حذف المنتج من هذا المحل؟');
    handleDeleteBtn('.branch-product-delete-btn', 'هل أنت متأكد من حذف المنتج من هذا الفرع؟');
});
</script>
@endsection