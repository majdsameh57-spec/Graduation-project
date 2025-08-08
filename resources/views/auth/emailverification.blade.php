<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password (v2)</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('projectOne/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('projectOne/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('projectOne/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('projectOne/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('projectOne/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="assets/index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">البريد غير مفعل يرجى التحقق من البريد</p>
      <form method="get" action="{{ route('verification.request') }}">
        @csrf
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">ارسال طلب تفعيل</button>
          </div>
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="login.html">Login</a>
      </p>
    </div>
  </div>
</div>
<script src="{{asset('projectOne/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('projectOne/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('projectOne/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('projectOne/plugins/toastr/toastr.min.js')}}"></script>
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
</body>
</html>
