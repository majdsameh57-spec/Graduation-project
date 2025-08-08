@extends("parent")

@section('style')
<style>
    #message_success {
        z-index: 1050 !important;
    }
    .form-group, .mb-3 {
        margin-bottom: 1.25rem;
    }
    h2.form-title {
        margin-bottom: 2rem;
        font-weight: 700;
        color: #0d6efd;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css"/>
@endsection

@section('pages-title', 'Update Password')
@section('pages-home', 'New')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="form-title text-center">تغيير كلمة المرور</h2>
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-password', $user->id)}}" novalidate>
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="password-input" class="form-label">كلمة المرور</label>
                        <input type="password"
                                class="form-control"
                                id="password-input"
                                placeholder="كلمة المرور الحالية"
                                name="old-password"
                                value="{{ old('old-password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password-input" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password"
                                class="form-control"
                                id="password-input"
                                placeholder="كلمة المرور الجديدة"
                                name="new-password"
                                value="{{ old('new-password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password-input" class="form-label">تاكيد كلمة المرور الجديدة</label>
                        <input type="password"
                                class="form-control"
                                id="password-input"
                                placeholder="تاكيد كلمة المرور الجديدة"
                                name="new-password_confirmation"
                                value="{{ old('new-password_confirmation') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('projectOne/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        bsCustomFileInput.init();
    });

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
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
<script>
  const input = document.querySelector("#input_mobile");
  if(input) {
    const iti = window.intlTelInput(input, {
      initialCountry: "auto",
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js",
    });
  }
</script>
@endsection
