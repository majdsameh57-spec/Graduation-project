@extends('MerchantControlPanel.parent')
@section('title', ' سيولتك - تعديل صلاحيات التاجر' )

@section('content')
    <div class="container my-5" style="max-width: 900px;">
        {{-- جدول الادوار --}}
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th> الصلاحيات</th>
                    <th> الدور</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rolePermission as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $permission->name }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="permission_{{ $permission->id }}"
                                    onchange="updateRolePermission('{{ $permission->id }}')" @checked(in_array($permission->id, $merchantPermission))>
                                <label for="permission_{{ $permission->id }}"></label>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">لا توجد ادوار حتى الآن.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function updateRolePermission(permissionId) {
            axios.post('{{route('merchants.permissions.update',$merchant->id)}}', {
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
