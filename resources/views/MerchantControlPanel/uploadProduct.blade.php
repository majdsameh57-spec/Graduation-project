@extends('MerchantControlPanel.parent')
@section('title', 'سيولتك - رفع منتج')
@section('page_title', 'رفع منتج جديد')

@section('breadcrumb')
    <li class="breadcrumb-item active">رفع منتج جديد</li>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-section {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .form-section-title {
        font-weight: 600;
        color: #0047b3;
        margin-bottom: 1rem;
    }
    .required-field::after {
        content: "*";
        color: #dc3545;
        margin-right: 4px;
    }
    .product-image-preview {
        max-width: 150px;
        border-radius: 8px;
        margin-top: 10px;
        box-shadow: 0 2px 8px rgba(0,71,179,0.1);
        border: 1px solid #e3f2fd;
        overflow: hidden;
    }
    .select2-container--default .select2-selection--multiple {
        border-color: #ced4da;
        min-height: 38px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-mt-12 mx-auto">
            <div class="dashboard-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title m-0">
                        <i class="fas fa-box"></i>
                        <span>رفع منتج جديد</span>
                    </h3>
                </div>

                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-store me-2"></i>معلومات المتجر والفروع
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">اختر المحل</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    <select name="shop_id" id="shop_id" class="form-select" required>
                                        <option value="">اختر المحل</option>
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى اختيار محل
                                </div>
                            </div>
                            
                            <div class="col-md-6" id="branch-wrapper" style="display:none;">
                                <label class="form-label required-field">اختر الفروع</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select name="branch_ids[]" id="branch_ids" multiple class="form-select">
                                        {{-- الخيارات ستتم إضافتها ديناميكياً --}}
                                    </select>
                                </div>
                                <small class="text-muted">يمكنك اختيار أكثر من فرع</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-info-circle me-2"></i>تفاصيل المنتج
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">اسم المنتج</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="أدخل اسم المنتج" required>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال اسم المنتج
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label required-field">السعر (شيكل)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-shekel-sign"></i></span>
                                    <input type="number" name="price" step="0.01" class="form-control" placeholder="أدخل سعر المنتج" required>
                                </div>
                                <div class="invalid-feedback">
                                    يرجى إدخال سعر المنتج
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">وصف المنتج</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                    <textarea name="description" class="form-control" rows="3" placeholder="وصف تفصيلي للمنتج (اختياري)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-image me-2"></i>صورة المنتج
                        </h4>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">اختر صورة للمنتج</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                                <small class="text-muted">يفضل استخدام صور بمقاس 1:1 أو 4:3</small>
                                <div id="image-preview-container"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-credit-card me-2"></i>طرق الدفع
                        </h4>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required-field">اختر طرق الدفع المتاحة</label>
                                @if ($paymentMethod->isEmpty())
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        لا يوجد لديك طرق دفع حالياً.
                                        <br>
                                        <a href="{{ route('paymentMethods.create') }}" class="alert-link">
                                            اضغط هنا لإضافة طريقة دفع جديدة
                                        </a>
                                    </div>
                                @else
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                        <select name="payment_methods[]" id="payment_methods" multiple="multiple" required class="form-select">
                                            @foreach ($paymentMethod as $method)
                                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="text-muted">يمكنك اختيار أكثر من طريقة دفع</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save me-2"></i>
                                <span>حفظ المنتج</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        
        const shopSelect = document.getElementById('shop_id');
        const branchWrapper = document.getElementById('branch-wrapper');
        const branchSelect = document.getElementById('branch_ids');
        const branches = @json($branches);

        function updateBranches() {
            const shopId = shopSelect.value;
            branchSelect.innerHTML = '';
            let found = false;
            
            if (!shopId) {
                branchWrapper.style.display = 'none';
                return;
            }
            
            branches.forEach(branch => {
                if (branch.shop_id == shopId) {
                    const option = document.createElement('option');
                    option.value = branch.id;
                    option.textContent = branch.location;
                    branchSelect.appendChild(option);
                    found = true;
                }
            });
            
            branchWrapper.style.display = found ? '' : 'none';
        }

        shopSelect.addEventListener('change', updateBranches);
        
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview-container');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="product-image-preview mt-2">
                            <img src="${e.target.result}" class="img-fluid" alt="معاينة الصورة">
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
            }
        });

        $(document).ready(function() {
            $('#payment_methods').select2({
                placeholder: "اختر طرق الدفع",
                dir: "rtl",
                language: "ar"
            });
        });
        
        @if (session('message'))
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
        Toast.fire({
            icon: '{{ session('icon') }}',
            title: '{{ session('message') }}'
        });
        @endif
    });
</script>
@endsection