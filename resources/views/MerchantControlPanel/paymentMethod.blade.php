@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - طرق الدفع')
@section('page_title', 'إدارة طرق الدفع')

@section('breadcrumb')
    <li class="breadcrumb-item active">إدارة طرق الدفع</li>
@endsection

@section('styles')
<style>
    .payment-method-item {
        background-color: #f8fafc;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        border: 1px solid #e9ecef;
        padding: 16px;
    }
    .payment-method-item:hover {
        box-shadow: 0 4px 12px rgba(0,71,179,0.1);
        transform: translateY(-2px);
    }
    .payment-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e3f2fd;
        color: #0047b3;
        margin-left: 12px;
    }
    .payment-name {
        font-weight: 600;
        color: #0047b3;
        font-size: 1rem;
    }
    .empty-state {
        text-align: center;
        padding: 30px 0;
    }
    .empty-state-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }
    @media (max-width: 767.98px) {
        .payment-actions {
            margin-top: 10px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-mt-12 mx-auto">
            <div class="row">
                <div class="col-md-5 col-lg-4 mb-4">
                    <div class="dashboard-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title m-0">
                                <i class="fas fa-plus-circle"></i>
                                <span>إضافة طريقة دفع</span>
                            </h3>
                        </div>
                        
                        <form action="{{ route('paymentMethods.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم طريقة الدفع</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-credit-card"></i>
                                    </span>
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder="مثال: نقداً، بطاقة بنكية..." value="{{ old('name') }}" required autofocus>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال اسم طريقة الدفع
                                </div>
                                <small class="text-muted">أضف طرق الدفع المتاحة في متجرك</small>
                            </div>
                            

                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>
                                إضافة طريقة الدفع
                            </button>
                        </form>
                        
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                نصائح
                            </h6>
                            <ul class="small text-muted ps-3">
                                <li>فعّل جميع خيارات الدفع الإلكتروني في متجرك لتسهيل عملية الدفع على العملاء دون أي عمولات</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7 col-lg-8">
                    <div class="dashboard-card">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                                <i class="fas fa-credit-card"></i>
                                <span class="card-title m-0">طرق الدفع المتاحة</span>
                            </div>
                        </div>
                        
                        @if($paymentMethods->count())
                            <div class="payment-methods-list">
                                @foreach($paymentMethods as $method)
                                    <div class="payment-method-item">
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-icon">
                                                    <i class="fas fa-{{ $method->is_online ?? false ? 'credit-card' : 'money-bill-wave' }}"></i>
                                                </div>
                                                <div>
                                                    <div class="payment-name">{{ $method->name }}</div>
                                                </div>
                                            </div>
                                            <div class="payment-actions mt-2 mt-md-0">
                                                <form action="{{ route('paymentMethods.destroy', $method->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash-alt me-1"></i>
                                                        <span>حذف</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-credit-card-slash"></i>
                                </div>
                                <h5>لا توجد طرق دفع متاحة</h5>
                                <p class="text-muted">لم تقم بإضافة أي طريقة دفع بعد.<br>
                                أضف طريقة دفع من النموذج المجاور لتظهر هنا.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });


        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        document.querySelectorAll('.payment-method-item form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = form.querySelector('button[type="submit"]');
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: 'سيتم حذف طريقة الدفع بشكل نهائي!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.disabled = true;
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: new FormData(form)
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('فشل الحذف');
                            return response.json();
                        })
                        .then(data => {
                            // حذف العنصر من الصفحة
                            form.closest('.payment-method-item').remove();
                            Toast.fire({ icon: 'success', title: 'تم حذف طريقة الدفع بنجاح' });
                        })
                        .catch(() => {
                            Toast.fire({ icon: 'error', title: 'حدث خطأ أثناء الحذف' });
                        })
                        .finally(() => { btn.disabled = false; });
                    }
                });
            });
        });
    });
</script>
@endsection