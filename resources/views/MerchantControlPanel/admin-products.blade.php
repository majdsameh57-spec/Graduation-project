@extends('MerchantControlPanel.parent')

@section('title', 'سيولتك - إدارة المنتجات')
@section('page_title', 'إدارة المنتجات')

@section('breadcrumb')
    <li class="breadcrumb-item active">قائمة المنتجات</li>
@endsection
@yield('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .product-card-list { display: block !important; }
}
@media (min-width: 576px) {
  .product-card-list { display: none !important; }
}
.product-card-list {
  padding-bottom: 1.5rem;
}
.product-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.product-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.product-card .product-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.product-card .product-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.product-card .product-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.product-card .badge {
  font-size: 0.97rem;
  padding: 0.35em 0.7em;
  border-radius: 0.7em;
}
.product-card .product-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.7rem;
}
.product-card .btn-info {
  background: #1976d2;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.product-card .btn-danger {
  background: #e53935;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.product-card .btn-info:hover, .product-card .btn-danger:hover {
  opacity: 0.92;
}
.product-card .product-meta b {
  color: #1976d2;
  font-weight: 600;
}
.product-card .product-meta i {
  color: #1976d2;
  margin-left: 2px;
}
</style>
@push('styles')
<style>
@media (max-width: 767.98px) {
  .table-card-mobile thead { display: none; }
  .table-card-mobile tbody tr {
    display: block;
    margin-bottom: 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    background: #fff;
    padding: 0.18rem 0.18rem;
    width: 100%;
  }
  .table-card-mobile td {
    display: block;
    width: 100%;
    border: none;
    font-size: 0.89rem;
    word-break: break-word;
    padding: 0.18rem 0.1rem 0.18rem 0.1rem;
    background: none;
  }
  .table-card-mobile td:before {
    display: block;
    content: attr(data-label);
    font-weight: bold;
    color: #666;
    text-align: right;
    font-size: 0.83rem;
    margin-bottom: 2px;
    padding: 0;
    min-width: 0;
  }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card mb-4 p-2 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
                    <h3 class="card-title m-0 fs-5 fs-md-4 d-flex align-items-center gap-2">
                        <i class="fas fa-box"></i>
                        <span>قائمة المنتجات</span>
                    </h3>
                    <form action="{{ route('admin.products') }}" method="GET" class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto" id="live-search-form">
                        <div class="input-group w-100">
                            <input type="text" name="q" class="form-control form-control-sm" 
                                   placeholder="البحث عن المنتج..." value="{{ request('q') }}" id="live-search-input">
                        </div>
                    </form>
                </div>
                
                <div class="collapse mb-4" id="searchCollapse">
                    <div class="card card-body bg-light border-0">
                        <form method="GET" action="{{ route('admin.products') }}" class="row g-3 align-items-end" id="live-search-form-adv">
                            <div class="col-md-4">
                                <label class="form-label">اسم المنتج</label>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="اسم المنتج..." id="live-search-input-adv">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">المحل</label>
                                <select name="shop_id" class="form-select" id="live-search-shop">
                                    <option value="">الكل</option>
                                    <!-- @foreach($shops ?? [] as $shop) -->
                                    <!-- <option value="{{ $shop->id }}" {{ request('shop_id') == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option> -->
                                    <!-- @endforeach -->
                                </select>
                            </div>
                            <div class="col-md-4 d-flex">
                                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo-alt"></i>
                                    <span>إعادة تعيين</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive-sm mt-2 mt-md-4 px-1 px-md-0" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped table-hover mb-0 table-card-mobile w-100">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">#</th>
                                <th>اسم المنتج</th>
                                <th>المحل</th>
                                <th>السعر</th>
                                <th style="width: 90px" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="text-center" data-label="#">
                                    {{ $loop->iteration + ($products->currentPage()-1)*$products->perPage() }}
                                </td>
                                <td class="fw-medium" data-label="اسم المنتج">{{ $product->name }}</td>
                                <td data-label="المحل">
                                    @if(isset($product->shop) && $product->shop)
                                    <span class="text-decoration-none">{{ $product->shop->name ?? '-' }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="السعر">
                                    <span class="fw-bold">{{ number_format($product->price, 2) }}</span>
                                    <span class="text-muted">₪</span>
                                </td>
                                <td class="text-center" data-label="الإجراءات">
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-product-btn" title="حذف المنتج" style="border-radius:0.6em; font-size:1.08rem; padding:0.45em 1.1em;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <p class="text-muted">لا يوجد منتجات لعرضها</p>
                                        @if(request()->has('q'))
                                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-redo-alt"></i> عرض كل المنتجات
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- كروت المنتجات للموبايل -->
                <div class="product-card-list mt-2">
                    @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-title">
                            <i class="fas fa-box"></i>
                            {{ $product->name }}
                        </div>
                        <div class="product-meta">
                            <span><b>المحل:</b> 
                                @if(isset($product->shop) && $product->shop)
                                    <a href="{{ route('admin.shops', $product->shop->id ?? 0) }}" class="text-decoration-none">{{ $product->shop->name ?? '-' }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                            <span><b>السعر:</b> <span class="fw-bold">{{ number_format($product->price, 2) }}</span> <span class="text-muted">₪</span></span>
                        </div>
                        <div class="product-actions d-flex gap-2 mt-3">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger delete-product-btn" title="حذف المنتج" style="border-radius:0.6em; font-size:1.08rem; padding:0.45em 1.1em;">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-box-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">لا يوجد منتجات لعرضها</p>
                        @if(request()->has('q'))
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-redo-alt"></i> عرض كل المنتجات
                        </a>
                        @endif
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 d-flex justify-content-center">
                    <div class="custom-pagination w-auto">
                        {{ $products->withQueryString()->appends(request()->except('page'))->links('vendor.pagination.custom-always') }}
                    </div>
                </div>
<!-- تحسين مظهر الترقيم فقط -->
<style>
.custom-pagination nav {
    direction: ltr;
}
.custom-pagination .pagination {
    justify-content: center;
    gap: 0.25rem;
}
.custom-pagination .page-item .page-link {
    border-radius: 50%;
    min-width: 2.3rem;
    min-height: 2.3rem;
    text-align: center;
    font-size: 1.08rem;
    color: #1976d2;
    border: 1.5px solid #e3e9f7;
    background: #f8fafc;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 1px 4px #e3e9f7a0;
    margin: 0 2px;
}
.custom-pagination .page-item.active .page-link {
    background: #1976d2;
    color: #fff;
    border-color: #1976d2;
    box-shadow: 0 2px 8px #1976d250;
}
.custom-pagination .page-item .page-link:hover {
    background: #e3e9f7;
    color: #1976d2;
    box-shadow: 0 2px 8px #1976d220;
}
.custom-pagination .page-item.disabled .page-link {
    color: #aaa;
    background: #f3f3f3;
    border-color: #e3e9f7;
}
.custom-pagination .page-link:focus {
    box-shadow: 0 0 0 0.15rem #1976d230;
}
</style>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-product-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = btn.closest('form');
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف هذا المنتج نهائياً!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53935',
                cancelButtonColor: '#1976d2',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // فلترة تلقائية بدون ريفرش (AJAX)
    let timer;
    var form = document.getElementById('live-search-form');
    var input = document.getElementById('live-search-input');
    function ajaxFilter() {
        const q = input ? input.value : '';
        const url = form.getAttribute('action') + '?q=' + encodeURIComponent(q);
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                // استخراج tbody الجديد
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.querySelector('table.table tbody');
                const oldTbody = document.querySelector('table.table tbody');
                if (newTbody && oldTbody) {
                    oldTbody.innerHTML = newTbody.innerHTML;
                }
                // استخراج كروت الموبايل الجديدة
                const newCards = doc.querySelector('.product-card-list');
                const oldCards = document.querySelector('.product-card-list');
                if (newCards && oldCards) {
                    oldCards.innerHTML = newCards.innerHTML;
                }
                // تحديث روابط الصفحات إذا لزم
                const newPag = doc.querySelector('.mt-4.d-flex.justify-content-end');
                const oldPag = document.querySelector('.mt-4.d-flex.justify-content-end');
                if (newPag && oldPag) {
                    oldPag.innerHTML = newPag.innerHTML;
                }
            });
    }
    if(input) {
        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(ajaxFilter, 400);
        });
    }

    // فلترة متقدمة (اسم المنتج + المحل)
    var formAdv = document.getElementById('live-search-form-adv');
    var inputAdv = document.getElementById('live-search-input-adv');
    var shopAdv = document.getElementById('live-search-shop');
    function ajaxFilterAdv() {
        const q = inputAdv ? inputAdv.value : '';
        const shop = shopAdv ? shopAdv.value : '';
        const url = formAdv.getAttribute('action') + '?q=' + encodeURIComponent(q) + '&shop_id=' + encodeURIComponent(shop);
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.querySelector('table.table tbody');
                const oldTbody = document.querySelector('table.table tbody');
                if (newTbody && oldTbody) {
                    oldTbody.innerHTML = newTbody.innerHTML;
                }
                const newCards = doc.querySelector('.product-card-list');
                const oldCards = document.querySelector('.product-card-list');
                if (newCards && oldCards) {
                    oldCards.innerHTML = newCards.innerHTML;
                }
                const newPag = doc.querySelector('.mt-4.d-flex.justify-content-end');
                const oldPag = document.querySelector('.mt-4.d-flex.justify-content-end');
                if (newPag && oldPag) {
                    oldPag.innerHTML = newPag.innerHTML;
                }
            });
    }
    if(inputAdv) {
        inputAdv.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(ajaxFilterAdv, 400);
        });
    }
    if(shopAdv) {
        shopAdv.addEventListener('change', ajaxFilterAdv);
    }
});
</script>
@endsection