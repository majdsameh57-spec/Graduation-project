@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - إدارة المحلات')
@section('page_title', 'إدارة المحلات')
@yield('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .shop-card-list { display: block !important; }
}
@media (min-width: 576px) {
  .shop-card-list { display: none !important; }
}
.shop-card-list {
  padding-bottom: 1.5rem;
}
.custom-modal.show {
  opacity: 1;
  visibility: visible;
  display: flex;
}
.shop-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.shop-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.shop-card .shop-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.shop-card .shop-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.shop-card .shop-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.shop-card .badge {
  font-size: 0.97rem;
  padding: 0.35em 0.7em;
  border-radius: 0.7em;
}
.shop-card .shop-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.7rem;
}
.shop-card .btn-info {
  background: #1976d2;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.shop-card .btn-danger {
  background: #e53935;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.shop-card .btn-info:hover, .shop-card .btn-danger:hover {
  opacity: 0.92;
}
.shop-card .shop-meta b {
  color: #1976d2;
  font-weight: 600;
}
.shop-card .shop-meta i.fa-calendar-alt {
  color: #1976d2;
  margin-left: 2px;
}
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

@push('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .shop-card-list { display: block !important; }
}
</style>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item active">قائمة المحلات</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card mb-4 p-2 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
                    <h3 class="card-title m-0 fs-5 fs-md-4 d-flex align-items-center gap-2">
                        <i class="fas fa-store"></i>
                        <span>قائمة المحلات</span>
                    </h3>
                    <form action="{{ route('admin.shops') }}" method="GET" class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto" id="live-search-form">
                        <div class="input-group w-100">
                            <input type="text" name="q" class="form-control form-control-sm" 
                                   placeholder="البحث عن المحل..." value="{{ request('q') }}" id="live-search-input">
                        </div>
                    </form>
                </div>
                
                <div class="collapse mb-4" id="searchCollapse">
                    <div class="card card-body bg-light border-0">
                        <form method="GET" action="{{ route('admin.shops') }}" class="row g-3 align-items-end" id="live-search-form">
                            <div class="col-md-4">
                                <label class="form-label">اسم المحل</label>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="اسم المحل..." id="live-search-input">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">حالة المحل</label>
                                <select name="status" class="form-select" id="live-search-status">
                                    <option value="">الكل</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>مفعل</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير مفعل</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('admin.shops') }}" class="btn btn-secondary">
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
                                <th>اسم المحل</th>
                                <th>التاجر التابع له</th>
                                <th>عدد الفروع</th>
                                <th>الحالة</th>
                                <th>تاريخ الإضافة</th>
                                <th style="width: 90px" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shops as $shop)
                                <tr>
                                    <td class="text-center" data-label="#">{{ $loop->iteration + ($shops->currentPage()-1)*$shops->perPage() }}</td>
                                    <td class="fw-medium" data-label="اسم المحل">{{ $shop->name }}</td>
                                    <td data-label="التاجر التابع له">
                                        @if($shop->merchant)
                                        <span class="text-decoration-none">{{ $shop->merchant->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="عدد الفروع">
                                        <span class="badge bg-primary">{{ $shop->branches_count ?? ($shop->branches->count() ?? 0) }}</span>
                                        فرع
                                    </td>
                                    <td data-label="الحالة">
                                        @if($shop->is_active ?? true)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>مفعل
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>غير مفعل
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="تاريخ الإضافة">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        {{ $shop->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="text-center" data-label="الإجراءات">
                                        <form action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-shop-btn" title="حذف المحل" style="border-radius:0.6em; font-size:1.08rem; padding:0.45em 1.1em;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-store-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="text-muted">لا يوجد محلات مطابقة لعرضها</p>
                                            @if(request()->has('q') || request()->has('status'))
                                            <a href="{{ route('admin.shops') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-redo-alt"></i> عرض كل المحلات
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="shop-card-list mt-2">
                    @forelse($shops as $shop)
                    <div class="shop-card">
                        <div class="shop-title">
                            <i class="fas fa-store"></i>
                            {{ $shop->name }}
                        </div>
                        <div class="shop-meta">
                            <span><b>التاجر:</b> 
                                @if($shop->merchant)
                                    <a href="{{ route('merchants.edit', $shop->merchant->id ?? 0) }}" class="text-decoration-none">{{ $shop->merchant->name }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                            <span><b>عدد الفروع:</b> <span class="badge bg-primary">{{ $shop->branches_count ?? ($shop->branches->count() ?? 0) }}</span></span>
                        </div>
                        <div class="shop-meta">
                            <span><b>الحالة:</b> 
                                @if($shop->is_active ?? true)
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>مفعل</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>غير مفعل</span>
                                @endif
                            </span>
                            <span><b>تاريخ الإضافة:</b> <i class="fas fa-calendar-alt text-muted me-1"></i> {{ $shop->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="shop-actions d-flex gap-2 mt-3">
                            <form action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger delete-shop-btn" title="حذف المحل" style="border-radius:0.6em; font-size:1.08rem; padding:0.45em 1.1em;">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-store-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">لا يوجد محلات مطابقة لعرضها</p>
                        @if(request()->has('q') || request()->has('status'))
                        <a href="{{ route('admin.shops') }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-redo-alt"></i> عرض كل المحلات
                        </a>
                        @endif
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 d-flex justify-content-center">
                    <div class="custom-pagination w-auto">
                        {{ $shops->withQueryString()->appends(request()->except('page'))->links('vendor.pagination.custom-always') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-shop-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = btn.closest('form');
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف هذا المحل وجميع المنتجات المرتبطة به نهائياً!',
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
});
document.addEventListener('DOMContentLoaded', function() {
    let timer;
    var form = document.getElementById('live-search-form');
    var input = document.getElementById('live-search-input');
    var status = document.getElementById('live-search-status');
    function ajaxFilter() {
        const q = input ? input.value : '';
        const s = status ? status.value : '';
        const url = form.getAttribute('action') + '?q=' + encodeURIComponent(q) + '&status=' + encodeURIComponent(s);
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
                const newCards = doc.querySelector('.shop-card-list');
                const oldCards = document.querySelector('.shop-card-list');
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
    if(input) {
        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(ajaxFilter, 400);
        });
    }
    if(status) {
        status.addEventListener('change', ajaxFilter);
    }
});
</script>
@endsection
