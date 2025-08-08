@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - تعديل بيانات التاجر')
@section('styles')

@endsection
@section('content')
    <div class="container mt-3">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100 fade-in">
            <h1 class="text-3xl font-bold text-[#0054d7] mb-8 flex items-center gap-2">الملف الشخصي </h1>

            <form method="post" action="{{ route('admins.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label"> الاسم</label>
                    <input type="name" name="name" class="form-control" id="name" value="{{ old('name') ?? $data->name}}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">📧 البريد الالكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') ?? $data->email}}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label"> رقم الهاتف</label>
                    <input type="mobile" name="mobile" class="form-control" id="mobile" value="{{ old('mobile') ?? $data->mobile}}"
                        required>
                </div>


                <div class="form-group">
                    <label>Select Role</label>
                    <select class="form-control" name="role_id" id="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">دخول</button>
                </div>
                </p>
            </form>
        </div>
    </div>
@endsection
