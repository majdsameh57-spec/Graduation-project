@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - تعديل صلاحيات الدور')
@section('page_title', 'إدارة صلاحيات الدور')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الأدوار</a></li>
    <li class="breadcrumb-item active">تعديل صلاحيات الدور</li>
@endsection
@push('styles')
<style>
@media (max-width: 575.98px) {
  .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
    display: none !important;
  }
  .role-permission-card-list { 
    display: block !important;
    padding-bottom: 1.5rem;
  }
}
@media (min-width: 576px) {
  .role-permission-card-list { 
    display: none !important;
    padding: 0 !important;
    margin: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
  }
}

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

.role-permission-card-list {
  padding-bottom: 1.5rem;
}

.role-permission-card {
  border: none;
  border-radius: 1.1rem;
  box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
  background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
  margin-bottom: 1.2rem;
  padding: 1.1rem 1.2rem 0.9rem 1.2rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.role-permission-card:hover {
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
}
.role-permission-card .permission-title {
  font-weight: bold;
  font-size: 1.13rem;
  margin-bottom: 0.7rem;
  color: #2d3a5a;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.6rem;
}
.role-permission-card .permission-title i {
  color: #1976d2;
  font-size: 1.3rem;
}
.role-permission-card .permission-meta {
  font-size: 0.99rem;
  color: #444;
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  flex-wrap: wrap;
}
.role-permission-card .permission-meta b {
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
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.card-title i {
  color: #1976d2;
  font-size: 1.3rem;
}

.custom-switch-sm {
  display: inline-block;
  position: relative;
}
.custom-switch-sm input {
  opacity: 0;
  width: 0;
  height: 0;
}
.custom-switch-sm .switch {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 22px;
}
.custom-switch-sm .slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}
.custom-switch-sm .slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}
.custom-switch-sm input:checked + .slider {
  background-color: #1976d2;
}
.custom-switch-sm input:checked + .slider:before {
  transform: translateX(22px);
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
                        <i class="fas fa-user-shield"></i>
                        <span>صلاحيات دور: {{ $role->name }}</span>
                    </h3>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right"></i>
                        <span>العودة للأدوار</span>
                    </a>
                </div>
                
                <div class="table-responsive-sm mt-2 mt-md-4 px-1 px-md-0" style="overflow-x:auto; min-width: 0;">
                    <table class="table table-bordered table-striped table-hover mb-0 table-card-mobile w-100">
                        <thead>
                            <tr>
                                <th style="width: 60px" class="text-center">#</th>
                                <th>الاسم</th>
                                <th>نوع المستخدم</th>
                                <th style="width: 100px" class="text-center">الإعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $data)
                                <tr>
                                    <td class="text-center" data-label="#">{{ $loop->index + 1 }}</td>
                                    <td class="fw-medium" data-label="الاسم">{{ $data->name }}</td>
                                    <td data-label="نوع المستخدم">{{ $data->guard_name }}</td>
                                    <td class="text-center" data-label="الإعدادات">
                                        <div class="custom-switch-sm">
                                            <label class="switch">
                                                <input type="checkbox" id="permission_{{ $data->id }}"
                                                    onchange="updateRolePermissions('{{ $data->id }}')"
                                                    @checked($data->assigned)>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="role-permission-card-list mt-2">
                    @foreach ($permissions as $data)
                    <div class="role-permission-card">
                        <div class="permission-title">
                            <div>
                                <i class="fas fa-key me-2"></i>
                                {{ $data->name }}
                            </div>
                            <div class="custom-switch-sm">
                                <label class="switch">
                                    <input type="checkbox" id="mobile_permission_{{ $data->id }}"
                                        onchange="updateRolePermissions('{{ $data->id }}')"
                                        @checked($data->assigned)>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="permission-meta">
                            <span><b>نوع المستخدم:</b> {{ $data->guard_name }}</span>
                        </div>
                    </div>
                    @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script>
    function updateRolePermissions(permissionId) {
        const desktopCheckbox = document.getElementById(`permission_${permissionId}`);
        const mobileCheckbox = document.getElementById(`mobile_permission_${permissionId}`);
        
        if (desktopCheckbox && mobileCheckbox) {
            if (this.id === `permission_${permissionId}`) {
                mobileCheckbox.checked = desktopCheckbox.checked;
            } else if (this.id === `mobile_permission_${permissionId}`) {
                desktopCheckbox.checked = mobileCheckbox.checked;
            }
        }
        
        fetch('{{ route('roles.update-permission') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    permission_id: permissionId,
                    role_id: '{{ $role->id }}'
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        throw errData;
                    });
                }
                return response.json();
            })
            .then(data => {
                Toast.fire({
                    icon: 'success',
                    title: data.message || 'تم تحديث الصلاحيات بنجاح'
                });
            })
            .catch(error => {
                let message = 'حدث خطأ غير متوقع';
                if (error && error.message) {
                    message = error.message;
                }
                Toast.fire({
                    icon: 'error',
                    title: message
                });
            });
    }
    
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        bsCustomFileInput?.init();
        
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