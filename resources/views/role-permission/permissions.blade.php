@extends('MerchantControlPanel.parent')
@section('title', ' سيولتك - عرض الصلاحيات')
@section('page_title', 'إدارة الصلاحيات')

@section('breadcrumb')
    <li class="breadcrumb-item active">عرض الصلاحيات</li>
@endsection
@push('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .permission-card-list { 
    display: block !important;
    padding-bottom: 1.5rem;
  }
}

@media (min-width: 576px) {
  .permission-card-list { 
    display: none !important;
    padding: 0 !important;
    margin: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
  }
}

/* Table responsive styles */
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

.permission-card-list {
  padding-bottom: 1.5rem;
}

.permission-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.permission-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.permission-card .permission-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.permission-card .permission-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.permission-card .permission-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.permission-card .permission-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.7rem;
}
.permission-card .btn-primary {
  background: #0047b3;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.permission-card .btn-info {
  background: #1976d2;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.permission-card .btn-danger {
  background: #e53935;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.permission-card .btn:hover {
  opacity: 0.92;
}
.permission-card .permission-meta b {
  color: #1976d2;
  font-weight: 600;
}

.dashboard-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: #fff;
  margin-bottom: 1.5rem;
}

.permissions-table thead th {
  background: #e3f2fd;
  color: #0047b3;
  font-weight: bold;
  font-size: 1.08rem;
  border-bottom: 2px solid #b6d4fe;
}
.permissions-table td, .permissions-table th {
  vertical-align: middle !important;
  border-left: 1.5px solid #e3e8ef;
  border-right: 1.5px solid #e3e8ef;
}
.permissions-table {
  border-radius: 14px;
  overflow: hidden;
  border: 2.5px solid #b6d4fe;
  box-shadow: 0 2px 12px 0 rgba(0,71,179,0.07);
}
.permissions-table tr {
  border-bottom: 1.5px solid #e3e8ef;
}
.permissions-table tbody tr:last-child {
  border-bottom: none;
}
@media (max-width: 991px) {
  .permissions-table {
      font-size: 0.97rem;
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
                        <i class="fas fa-shield-alt text-primary"></i>
                        <span>إدارة الصلاحيات</span>
                    </h3>
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>إضافة صلاحية</span>
                    </a>
                </div>
                
                <div class="table-responsive-sm mt-2 mt-md-4 px-1 px-md-0" style="overflow-x:auto; min-width: 0;">
                    <table class="table table-hover align-middle mb-0 table-card-mobile permissions-table w-100">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">#</th>
                                <th>الصلاحية</th>
                                <th style="width: 150px" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td class="text-center" data-label="#">{{ $loop->iteration }}</td>
                                    <td class="fw-medium" data-label="الصلاحية">{{ $permission->name }}</td>
                                    <td class="text-center" data-label="الإجراءات">
                                        <div class="btn-group">
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-exclamation-circle text-muted mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="text-muted">لا توجد صلاحيات حتى الآن.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="permission-card-list mt-2">
                    @forelse ($permissions as $permission)
                    <div class="permission-card">
                        <div class="permission-title">
                            <i class="fas fa-key"></i>
                            {{ $permission->name }}
                        </div>
                        <div class="permission-actions d-flex gap-2">
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                    <i class="fas fa-trash me-1"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle text-muted mb-2" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">لا توجد صلاحيات حتى الآن.</p>
                    </div>
                    @endforelse
                </div>
                
                @if(isset($permissions) && method_exists($permissions, 'hasPages') && $permissions->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $permissions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
    });
</script>
@endsection