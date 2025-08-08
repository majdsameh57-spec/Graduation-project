@extends('MerchantControlPanel.parent')
@section('title', ' سيولتك - عرض الادوار')
@section('page_title', 'إدارة الأدوار')

@section('breadcrumb')
    <li class="breadcrumb-item active">عرض الأدوار</li>
@endsection
@push('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile-wrapper {
    display: none !important;
  }
  .role-card-list {
    display: block !important;
    padding-bottom: 1.5rem;
  }
}
@media (min-width: 576px) {
  .table-card-mobile-wrapper {
    display: block !important;
  }
  .role-card-list {
    display: none !important;
  }
}

.role-card-list {
  padding-bottom: 1.5rem;
}

.role-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.role-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.role-card .role-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.role-card .role-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.role-card .role-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.role-card .badge {
  font-size: 0.97rem;
  padding: 0.35em 0.7em;
  border-radius: 0.7em;
}
.role-card .role-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.7rem;
}
.role-card .btn-primary {
  background: #0047b3;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.role-card .btn-info {
  background: #1976d2;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.role-card .btn-danger {
  background: #e53935;
  border: none;
  color: #fff;
  font-size: 1.08rem;
  padding: 0.45em 1.1em;
  border-radius: 0.6em;
}
.role-card .btn:hover {
  opacity: 0.92;
}
.role-card .role-meta b {
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
.card-title {
  font-weight: bold;
  color: #2d3a5a;
  margin-bottom: 1.2rem;
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
                        <i class="fas fa-user-tag text-primary"></i>
                        <span>إدارة الأدوار</span>
                    </h3>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>إضافة دور جديد</span>
                    </a>
                </div>
                
                  <div class="table-responsive-sm mt-2 mt-md-4 px-1 px-md-0 table-card-mobile-wrapper" style="overflow-x:auto; min-width: 0;">
                    <table class="table table-bordered table-striped table-hover mb-0 table-card-mobile w-100">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">#</th>
                                <th>الاسم</th>
                                <th>نوع المستخدم</th>
                                <th>الصلاحيات</th>
                                <th style="width: 150px" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $data)
                                <tr>
                                    <td class="text-center" data-label="#">{{ $loop->index + 1 }}</td>
                                    <td class="fw-medium" data-label="الاسم">{{ $data->name }}</td>
                                    <td data-label="نوع المستخدم">{{ $data->guard_name }}</td>
                                    <td data-label="الصلاحيات">
                                        <span class="badge bg-info">{{ $data->permissions_count }}</span>
                                        صلاحية
                                    </td>
                                    <td class="text-center" data-label="الإجراءات">
                                        <div class="btn-group">
                                            <a href="{{ route('roles.show', $data->id) }}"
                                                class="btn btn-sm btn-primary" title="عرض الصلاحيات">
                                                <i class="fas fa-user-shield"></i>
                                            </a>
                                            <a href="{{ route('roles.edit', $data->id) }}"
                                                class="btn btn-sm btn-info" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                onclick="confirmDestroy('{{ route('roles.destroy', $data->id) }}', this)"
                                                class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-user-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="text-muted">لا توجد أدوار لعرضها</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="role-card-list mt-2">
                    @forelse($roles as $data)
                    <div class="role-card">
                        <div class="role-title">
                            <i class="fas fa-user-tag"></i>
                            {{ $data->name }}
                        </div>
                        <div class="role-meta">
                            <span><b>نوع المستخدم:</b> {{ $data->guard_name }}</span>
                        </div>
                        <div class="role-meta">
                            <span><b>الصلاحيات:</b> <span class="badge bg-info">{{ $data->permissions_count }}</span> صلاحية</span>
                        </div>
                        <div class="role-actions d-flex gap-2">
                            <a href="{{ route('roles.show', $data->id) }}" class="btn btn-sm btn-primary" title="عرض الصلاحيات">
                                <i class="fas fa-user-shield"></i>
                            </a>
                            <a href="{{ route('roles.edit', $data->id) }}" class="btn btn-sm btn-info" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="confirmDestroy('{{ route('roles.destroy', $data->id) }}', this)" class="btn btn-sm btn-danger" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">لا توجد أدوار لعرضها</p>
                    </div>
                    @endforelse
                </div>
                
                @if(isset($roles) && method_exists($roles, 'hasPages') && $roles->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $roles->links() }}
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

    function confirmDestroy(url, button) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف هذا الدور بشكل نهائي!",
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
                form.action = url;
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
</script>
@endsection