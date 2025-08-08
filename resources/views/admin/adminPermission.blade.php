@extends('MerchantControlPanel.parent')
@section('title', ' سيولتك - صلاحيات الادمن')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
    <div class="container py-4">
        <style>
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
            @media (max-width: 600px) {
                .permissions-table thead {
                    display: none;
                }
                .permissions-table tr {
                    display: block;
                    margin-bottom: 0.7rem;
                    border-radius: 10px;
                    box-shadow: 0 1px 6px #e3e8ef;
                }
                .permissions-table td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.7rem 1rem;
                    border: none;
                    border-bottom: 1px solid #e3e8ef;
                }
                .permissions-table td:before {
                    content: attr(data-label);
                    font-weight: bold;
                    color: #0047b3;
                }
            }
        </style>
        <div class="dashboard-card p-0">
            <h5 class="mb-4 px-4 pt-4" style="color:#0054d7; font-weight:bold;"><i class="fas fa-user-shield me-2"></i>جدول صلاحيات الأدمن</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 permissions-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الصلاحية</th>
                            <th>الدور</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rolePermission as $permission)
                            <tr>
                                <td data-label="#">{{ $loop->iteration }}</td>
                                <td data-label="الصلاحية" class="text-start">{{ $permission->name }}</td>
                                <td data-label="الدور">{{ $role->name }}</td>
                                <td data-label="الإجراءات">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="permission_{{ $permission->id }}"
                                            onchange="upadteRolePermission('{{ $permission->id }}')" @checked($permission->assigned)>
                                        <label for="permission_{{ $permission->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">لا توجد ادوار حتى الآن.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function upadteRolePermission(permissionId) {
            axios.post('{{ route('admins.permissions.update', $admin->id) }}', {
                    permission_id: permissionId,
                })
                .then(response => {
                    toastr.success(response.data.message)
                })
                .catch(error => {
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection
