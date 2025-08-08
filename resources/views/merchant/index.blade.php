@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - عرض التجار')
@section('page_title', 'إدارة التجار')

@section('breadcrumb')
    <li class="breadcrumb-item active">قائمة التجار</li>
@endsection

<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .merchant-card-list {
    display: block !important;
    padding-bottom: 1.5rem;
  }
}
@media (min-width: 576px) {
  .merchant-card-list {
    display: none !important;
    padding: 0 !important;
    margin: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
  }
}
.merchant-card-list {
  padding-bottom: 1.5rem;
}
.merchant-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.merchant-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.merchant-card .merchant-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.merchant-card .merchant-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.merchant-card .merchant-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.merchant-card .badge {
  font-size: 0.97rem;
  padding: 0.35em 0.7em;
  border-radius: 0.7em;
}
.merchant-card .merchant-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.7rem;
}
.merchant-card .btn-primary {
  background: #0047b3;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.merchant-card .btn-info {
  background: #1976d2;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.merchant-card .btn-danger {
  background: #e53935;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.merchant-card .btn:hover {
  opacity: 0.92;
}
.merchant-card .merchant-meta b {
  color: #1976d2;
  font-weight: 600;
}
.merchant-card .merchant-meta i {
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
                        <i class="fas fa-users"></i>
                        <span>قائمة التجار</span>
                    </h3>
<form id="merchant-search-form" action="{{ route('merchants.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto" autocomplete="off">
    <div class="input-group w-100">
        <input type="text" name="search" id="merchant-search-input" class="form-control form-control-sm" 
               placeholder="البحث عن تاجر..." value="{{ request('search') }}" autocomplete="off">
    </div>
</form>
                </div>
                
                
                <div class="table-responsive-sm mt-2 mt-md-4 px-1 px-md-0" style="overflow-x:auto; min-width: 0;">
                    <table class="table table-bordered table-striped table-hover mb-0 table-card-mobile w-100">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">#</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>نوع المستخدم</th>
                                <th>الصلاحيات</th>
                                <th style="width: 150px" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($merchants as $data)
                                <tr>
                                    <td class="text-center" data-label="#">{{ $loop->index + 1 }}</td>
                                    <td class="fw-medium" data-label="الاسم">{{ $data->name }}</td>
                                    <td data-label="البريد الالكتروني">{{ $data->email }}</td>
                                    <td data-label="نوع المستخدم">
                                        @foreach ($data->roles as $role)
                                            <span class="badge bg-primary me-1">{{ $role->guard_name }}</span>
                                        @endforeach
                                    </td>
                                    <td data-label="الصلاحيات">
                                        <span class="badge bg-info">{{ $data->permissions_count }}</span>
                                        صلاحية
                                    </td>
                                    <td class="text-center" data-label="الإجراءات">
                                        <div class="btn-group">
                                            <a href="{{ route('merchants.permissions.edit', $data->id) }}"
                                                class="btn btn-sm btn-primary" title="إدارة الصلاحيات">
                                                <i class="fas fa-user-shield"></i>
                                            </a>
                                            <a href="{{ route('merchants.edit', $data->id) }}"
                                                class="btn btn-sm btn-info" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                onclick="confirmDelete(this, '{{ route('merchants.destroy', $data->id) }}')"
                                                class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-user-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="text-muted">لا يوجد تجار مطابقين لعرضهم</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

<div class="merchant-card-list mt-2" id="merchant-card-list">
    @forelse($merchants as $data)
    <div class="merchant-card">
        <div class="merchant-title">
            <i class="fas fa-user-shield"></i>
            {{ $data->name }}
        </div>
        <div class="merchant-meta">
            <span><b>البريد الإلكتروني:</b> {{ $data->email }}</span>
        </div>
        <div class="merchant-meta">
            <span><b>نوع المستخدم:</b> 
                @foreach ($data->roles as $role)
                    <span class="badge bg-primary me-1">{{ $role->guard_name }}</span>
                @endforeach
            </span>
        </div>
        <div class="merchant-meta">
            <span><b>الصلاحيات:</b> <span class="badge bg-info">{{ $data->permissions_count }}</span> صلاحية</span>
        </div>
        <div class="merchant-actions d-flex gap-2">
            <a href="{{ route('merchants.permissions.edit', $data->id) }}" class="btn btn-sm btn-primary" title="إدارة الصلاحيات">
                <i class="fas fa-user-shield"></i>
            </a>
            <a href="{{ route('merchants.edit', $data->id) }}" class="btn btn-sm btn-info" title="تعديل">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" onclick="confirmDelete(this, '{{ route('merchants.destroy', $data->id) }}')" class="btn btn-sm btn-danger" title="حذف">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="fas fa-user-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
        <p class="text-muted">لا يوجد تجار مطابقين لعرضهم</p>
    </div>
    @endforelse
</div>
                
                @if(isset($merchants) && method_exists($merchants, 'hasPages') && $merchants->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $merchants->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(button, actionUrl) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف هذا التاجر بشكل نهائي!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالحذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = actionUrl;
                form.style.display = 'none';
                var csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrf);
                var method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        bsCustomFileInput?.init();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        const status = @json(session('status'));
        const icon = @json(session('icon'));
        const message = @json(session('message'));

        if (status) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }

        @if ($errors->any())
            let errorMessages = {!! json_encode($errors->all()) !!};
            Toast.fire({
                icon: 'error',
                html: errorMessages.join('<br>')
            });
        @endif

        // البحث التلقائي مع تأخير بسيط (مثل صفحة المحلات)
        var searchInput = document.getElementById('merchant-search-input');
        var cardList = document.getElementById('merchant-card-list');
        var tableBody = document.querySelector('table.table tbody');
        var pagination = document.querySelector('.mt-4.d-flex.justify-content-end, .mt-4.d-flex.justify-content-center');
        let timer;
        function ajaxFilter() {
            var query = searchInput.value;
            var url = `{{ route('merchants.index') }}?search=${encodeURIComponent(query)}`;
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    var tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    var newCards = tempDiv.querySelector('#merchant-card-list');
                    if (newCards && cardList) {
                        cardList.innerHTML = newCards.innerHTML;
                    }
                    var newTableBody = tempDiv.querySelector('table.table tbody');
                    if (newTableBody && tableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }
                    var newPag = tempDiv.querySelector('.mt-4.d-flex.justify-content-end, .mt-4.d-flex.justify-content-center');
                    if (newPag && pagination) {
                        pagination.innerHTML = newPag.innerHTML;
                    }
                });
        }
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(ajaxFilter, 400);
            });
        }
    });
</script>
@endsection