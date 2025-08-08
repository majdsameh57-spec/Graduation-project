@extends('MerchantControlPanel.parent')

@section('title', 'سيولتك - عرض الادمن')
@section('page_title', 'إدارة حسابات المشرفين')

@section('breadcrumb')
    <li class="breadcrumb-item active">عرض المشرفين</li>
@endsection
@section('styles')
<style>
  @media (max-width: 575.98px) {
    .table-card-mobile, .table-card-mobile thead, .table-card-mobile tbody, .table-card-mobile tr, .table-card-mobile th, .table-card-mobile td {
      display: none !important;
    }
    .admin-card-list {
      display: block !important;
      padding-bottom: 1.5rem;
    }
  }
  @media (min-width: 576px) {
    .admin-card-list {
      display: none !important;
      padding: 0 !important;
      margin: 0 !important;
      height: 0 !important;
      overflow: hidden !important;
    }
  }
  .admin-card-list {
    padding-bottom: 1.5rem;
  }
  .admin-card {
    border: none;
    border-radius: 1.1rem;
    box-shadow: 0 4px 18px 0 rgba(44,62,80,0.10), 0 1.5px 4px 0 rgba(44,62,80,0.07);
    background: linear-gradient(135deg, #f8fafc 80%, #e3e9f7 100%);
    margin-bottom: 1.2rem;
    padding: 1.1rem 1.2rem 0.9rem 1.2rem;
    position: relative;
    transition: box-shadow 0.2s;
  }
  .admin-card:hover {
    box-shadow: 0 8px 32px 0 rgba(44,62,80,0.16), 0 2px 8px 0 rgba(44,62,80,0.10);
  }
  .admin-card .admin-title {
    font-weight: bold;
    font-size: 1.13rem;
    margin-bottom: 0.7rem;
    color: #2d3a5a;
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }
  .admin-card .admin-title i {
    color: #1976d2;
    font-size: 1.3rem;
  }
  .admin-card .admin-meta {
    font-size: 0.99rem;
    color: #444;
    margin-bottom: 0.45rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
    flex-wrap: wrap;
  }
  .admin-card .badge {
    font-size: 0.97rem;
    padding: 0.35em 0.7em;
    border-radius: 0.7em;
  }
  .admin-card .admin-actions {
    margin-top: 1rem;
    display: flex;
    gap: 0.7rem;
  }
  .admin-card .btn-primary {
    background: #0047b3;
    border: none;
    color: #fff;
    font-size: 1.08rem;
    padding: 0.45em 1.1em;
    border-radius: 0.6em;
  }
  .admin-card .btn-info {
    background: #1976d2;
    border: none;
    color: #fff;
    font-size: 1.08rem;
    padding: 0.45em 1.1em;
    border-radius: 0.6em;
  }
  .admin-card .btn-danger {
    background: #e53935;
    border: none;
    color: #fff;
    font-size: 1.08rem;
    padding: 0.45em 1.1em;
    border-radius: 0.6em;
  }
  .admin-card .btn:hover {
    opacity: 0.92;
  }
  .admin-card .admin-meta b {
    color: #1976d2;
    font-weight: 600;
  }
  .admin-card .admin-meta i {
    color: #1976d2;
    margin-left: 2px;
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
  @media (max-width: 1200px) and (min-width: 900px) {
    .container-fluid, .dashboard-card {
      padding-right: 0.3rem !important;
      padding-left: 0.3rem !important;
    }
    .dashboard-card {
      padding: 0.7rem 0.5rem !important;
      margin-bottom: 0.7rem !important;
    }
    .dashboard-card .card-title {
      font-size: 1.01rem !important;
      margin-bottom: 0.7rem !important;
    }
    body, .dashboard-card, .admin-card, .admin-meta, .admin-title {
      font-size: 0.95rem !important;
    }
    .dashboard-card .table {
      font-size: 0.93rem;
      min-width: 600px;
    }
    .dashboard-card .table th, .dashboard-card .table td {
      padding: 0.32rem 0.38rem;
    }
    .dashboard-card .table-responsive-xxl, .dashboard-card .table-responsive-xl, .dashboard-card .table-responsive-lg, .dashboard-card .table-responsive-md, .dashboard-card .table-responsive-sm {
      overflow-x: auto;
      max-width: 100%;
    }
  }
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card mb-4 p-2 p-md-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
                        <h3 class="card-title m-0 fs-5 fs-md-4 d-flex align-items-center gap-2">
                            <i class="fas fa-users-cog"></i>
                            <span>حسابات المشرفين</span>
                        </h3>
                        @can('Create-Admin')
                        <a href="{{ route('admins.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i>
                            <span>إضافة مشرف جديد</span>
                        </a>
                        @endcan
                    </div>
                    
                    <div class="table-responsive-xxl table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm mt-2 mt-md-4 px-1 px-md-0" style="overflow-x:auto;">
                        <table class="table table-bordered table-striped table-hover mb-0 table-card-mobile" style="min-width:700px;">
                            <thead>
                                <tr>
                                    <th style="width: 60px" class="text-center">#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>نوع المستخدم</th>
                                    <th>الصلاحيات</th>
                                    <th style="width: 150px" class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $data)
                                    <tr>
                                        <td class="text-center" data-label="#">{{ $loop->index + 1 }}</td>
                                        <td class="fw-medium" data-label="الاسم">{{ $data->name }}</td>
                                        <td data-label="البريد الإلكتروني">{{ $data->email }}</td>
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
                                                <a href="{{ route('admins.permissions.edit', $data->id) }}"
                                                    class="btn btn-sm btn-primary" title="إدارة الصلاحيات">
                                                    <i class="fas fa-user-shield"></i>
                                                </a>
                                                <a href="{{ route('admins.edit', $data->id) }}"
                                                    class="btn btn-sm btn-info" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                    onclick="confirmDestroy('{{ route('admins.destroy', $data->id) }}', this)"
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
                                                <p class="text-muted">لا توجد حسابات مشرفين لعرضها</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="admin-card-list mt-2">
                        @forelse($admins as $data)
                        <div class="admin-card">
                            <div class="admin-title">
                                <i class="fas fa-user-shield"></i>
                                {{ $data->name }}
                            </div>
                            <div class="admin-meta">
                                <span><b>البريد الإلكتروني:</b> {{ $data->email }}</span>
                            </div>
                            <div class="admin-meta">
                                <span><b>نوع المستخدم:</b> 
                                    @foreach ($data->roles as $role)
                                        <span class="badge bg-primary me-1">{{ $role->guard_name }}</span>
                                    @endforeach
                                </span>
                            </div>
                            <div class="admin-meta">
                                <span><b>الصلاحيات:</b> <span class="badge bg-info">{{ $data->permissions_count }}</span> صلاحية</span>
                            </div>
                            <div class="admin-actions d-flex gap-2">
                                <a href="{{ route('admins.permissions.edit', $data->id) }}" class="btn btn-sm btn-primary" title="إدارة الصلاحيات">
                                    <i class="fas fa-user-shield"></i>
                                </a>
                                <a href="{{ route('admins.edit', $data->id) }}" class="btn btn-sm btn-info" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" onclick="confirmDestroy('{{ route('admins.destroy', $data->id) }}', this)" class="btn btn-sm btn-danger" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="text-muted">لا توجد حسابات مشرفين لعرضها</p>
                        </div>
                        @endforelse
                    </div>
                    
                    @if(isset($admins) && method_exists($admins, 'hasPages') && $admins->hasPages())
                    <div class="mt-4 d-flex justify-content-end">
                        {{ $admins->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 