@extends('Liquidity.parent')
@section('title', 'سلة المشتريات')
@section('styles')
    <style>
        .cart-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cart-shop-name {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .table-responsive-cart {
                display: block;
                width: 100%;
                overflow-x: auto;
            }
            
            .cart-qty {
                width: 60px !important;
            }
        }
        
        @media (max-width: 576px) {
            #fake-payment-modal > div,
            #invoice-modal > div {
                width: 90% !important;
                padding: 24px 20px 16px 20px !important;
            }
            
            .form-control {
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('content')
<div class="container py-5">
    <h2 class="cart-title mb-4"><i class="fas fa-shopping-cart me-2"></i>سلة المشتريات</h2>
    <div id="cart-items" class="table-responsive-cart"></div>
    <div class="mt-4 text-end">
        <button class="btn btn-primary" id="checkout-btn">ادفع الآن</button>
    </div>
</div>
@endsection
@section('scripts')
<script>
function renderCart() {
    var cart = JSON.parse(localStorage.getItem('cart') || '[]');
    var html = '';
    if(cart.length === 0) {
        html = '<div class="alert alert-info">سلة المشتريات فارغة.</div>';
        document.getElementById('checkout-btn').style.display = 'none';
    } else {
        var shopName = '';
        if (cart[0].branch_name && cart[0].branch_name.trim() !== '') {
            shopName = cart[0].branch_name;
        } else if (cart[0].shop_name && cart[0].shop_name.trim() !== '') {
            shopName = cart[0].shop_name;
        } else if (cart[0].shop && isNaN(cart[0].shop)) {
            shopName = cart[0].shop;
        } else {
            shopName = '';
        }
        html += `<div class="alert alert-primary mb-3 cart-shop-name"><i class='fas fa-store me-2'></i>المتجر: ${shopName}</div>`;
        html += '<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>المنتج</th><th>السعر</th><th>الكمية</th><th>الإجمالي</th><th></th></tr></thead><tbody>';
        var total = 0;
        cart.forEach(function(p, i) {
            var subtotal = p.price * p.quantity;
            total += subtotal;
            html += `<tr>
                <td><div class="d-flex align-items-center"><img src="${p.image}" style="width:40px;height:40px;object-fit:cover;border-radius:8px;" class="me-2"> <span>${p.name}</span></div></td>
                <td>${p.price} شيكل</td>
                <td><input type='number' min='1' value='${p.quantity}' data-idx='${i}' class='form-control form-control-sm cart-qty' style='width:70px;'></td>
                <td>${subtotal} شيكل</td>
                <td><button class='btn btn-danger btn-sm remove-item' data-idx='${i}'><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">حذف</span></button></td>
            </tr>`;
        });
        html += `</tbody></table></div><div class='text-end fw-bold fs-5 mt-3'>الإجمالي: <span id='cart-total'>${total}</span> شيكل</div>`;
        document.getElementById('checkout-btn').style.display = 'inline-block';
    }
    document.getElementById('cart-items').innerHTML = html;
}
document.addEventListener('DOMContentLoaded', function() {
    renderCart();
    document.getElementById('cart-items').addEventListener('input', function(e) {
        if(e.target.classList.contains('cart-qty')) {
            var idx = e.target.dataset.idx;
            var cart = JSON.parse(localStorage.getItem('cart') || '[]');
            cart[idx].quantity = parseInt(e.target.value) || 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            if(window.updateCartBadge) updateCartBadge();
        }
    });
    document.getElementById('cart-items').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-item')) {
            var idx = e.target.dataset.idx;
            var cart = JSON.parse(localStorage.getItem('cart') || '[]');
            cart.splice(idx, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            if(window.updateCartBadge) updateCartBadge();
        }
    });
    document.getElementById('checkout-btn').addEventListener('click', function() {
        var cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if(cart.length === 0) return;
        var total = cart.reduce((sum, p) => sum + (p.price * p.quantity), 0);
        var shopName = '';
        if (cart[0].branch_name && cart[0].branch_name.trim() !== '') {
            shopName = cart[0].branch_name;
        } else if (cart[0].shop_name && cart[0].shop_name.trim() !== '') {
            shopName = cart[0].shop_name;
        } else if (cart[0].shop && isNaN(cart[0].shop)) {
            shopName = cart[0].shop;
        } else {
            shopName = '';
        }
        var payHtml = `<div id='fake-payment-modal' style='position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;'>
            <div style='background:#fff;padding:32px 28px 18px 28px;border-radius:18px;box-shadow:0 8px 32px rgba(0,0,0,0.13);min-width:340px;max-width:95vw;width:450px;'>
                <div style='text-align:center;font-size:1.3rem;font-weight:bold;margin-bottom:18px;'><i class="fas fa-credit-card me-2"></i>بوابة الدفع</div>
                <div class='mb-3' style='font-size:1.1rem;'>المتجر: <span style='color:#0054d7;font-weight:bold;'>${shopName}</span></div>
                <div class='mb-3' style='font-size:1.1rem;'>المبلغ المطلوب: <span style='color:#198754;font-weight:bold;'>${total} شيكل</span></div>
                <input type='text' class='form-control mb-3' placeholder='رقم البطاقة (مثال: 1234567812345678)' id='card-number-input' maxlength='16' inputmode='numeric' style='direction:ltr;width:100%;max-width:260px;margin:auto;' pattern='\d{16}' title='يجب إدخال 16 رقم'>
                <input type='text' class='form-control mb-4' placeholder='اسم حامل البطاقة' id='card-holder-input' style='width:100%;max-width:260px;margin:auto;'>
                <button class='btn btn-primary w-100 mb-2' id='pay-now-btn'>ادفع الآن</button>
                <button class='btn btn-link w-100' id='close-pay-modal'>إلغاء</button>
            </div>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', payHtml);
        document.getElementById('close-pay-modal').onclick = function() {
            document.getElementById('fake-payment-modal').remove();
        };
        document.getElementById('pay-now-btn').onclick = function() {
            var cardHolder = document.getElementById('card-holder-input');
            var cardNumber = document.getElementById('card-number-input');
            var cardHolderVal = cardHolder ? cardHolder.value : '';
            var cardNumberVal = cardNumber ? cardNumber.value.replace(/\s+/g, '') : '';
            var finalCardHolder = cardHolderVal && cardHolderVal.trim() !== '' ? cardHolderVal.trim() : 'العميل';
            window.__lastCardHolderName = finalCardHolder;
            if (!cardNumberVal || cardNumberVal.length !== 16 || !/^\d{16}$/.test(cardNumberVal)) {
                showToast('يرجى إدخال رقم بطاقة صحيح مكون من 16 رقم', 'danger');
                if(cardNumber) cardNumber.focus();
                return;
            }
            document.getElementById('fake-payment-modal').remove();
            setTimeout(function() {
                var invoiceHtml = `<div id='invoice-modal' style='position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;'>
                    <div style='background:#fff;padding:32px 28px 18px 28px;border-radius:18px;box-shadow:0 8px 32px rgba(0,0,0,0.13);min-width:340px;max-width:95vw;width:450px;'>
                        <div style='text-align:center;font-size:1.3rem;font-weight:bold;margin-bottom:18px;'><i class="fas fa-file-invoice me-2"></i>تم الدفع بنجاح!</div>
                        <div class='mb-4 text-center' style='font-size:1.1rem;'>هل ترغب بتنزيل الفاتورة؟</div>
                        <button class='btn btn-success w-100 mb-2' id='download-invoice-btn'>تنزيل الفاتورة</button>
                        <button class='btn btn-link w-100' id='close-invoice-modal'>إغلاق</button>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', invoiceHtml);
                document.getElementById('close-invoice-modal').onclick = function() {
                    document.getElementById('invoice-modal').remove();
                    localStorage.removeItem('cart');
                    renderCart();
                    if(window.updateCartBadge) updateCartBadge();
                };
function showToast(msg, type = 'info') {
    var color = (type === 'danger' || type === 'error') ? '#dc3545' : (type === 'success' ? '#198754' : '#0054d7');
    var icon = (type === 'danger' || type === 'error') ? 'fa-times-circle' : (type === 'success' ? 'fa-check-circle' : 'fa-info-circle');
    var toast = document.createElement('div');
    toast.innerHTML = `<div style="display:flex;align-items:center;gap:8px;"><i class='fas ${icon}'></i><span>${msg}</span></div>`;
    toast.style.cssText = 'position:fixed;top:30px;right:30px;z-index:99999;background:'+color+';color:#fff;padding:12px 22px;font-size:1.08rem;border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,0.13);font-family:Tajawal,sans-serif;transition:opacity 0.3s;opacity:0.97;pointer-events:none;';
    document.body.appendChild(toast);
    setTimeout(()=>{toast.style.opacity='0.1';}, 2200);
    setTimeout(()=>{if(toast.parentNode) toast.parentNode.removeChild(toast);}, 2600);
}

                document.getElementById('download-invoice-btn').onclick = function() {
                    var cardHolder = document.querySelector('#card-holder-input');
                    var cardHolderVal = (window.__lastCardHolderName && window.__lastCardHolderName !== '') ? window.__lastCardHolderName : 'العميل';
                    var cardNumber = document.querySelector('#card-number-input');
                    var cardNumberVal = cardNumber ? cardNumber.value.replace(/\s+/g, '') : '';
                    if (!cardNumberVal || cardNumberVal.length !== 16 || !/^\d{16}$/.test(cardNumberVal)) {
                        cardNumberVal = '0000000000000000';
                    }
                    var last4 = cardNumberVal.slice(-4);
                    var now = new Date();
                    var invoiceId = 'INV-' + now.getFullYear().toString().slice(-2) + (now.getMonth()+1).toString().padStart(2,'0') + now.getDate().toString().padStart(2,'0') + '-' + Math.floor(1000 + Math.random()*9000);
                    var dateStr = now.getFullYear() + '-' + (now.getMonth()+1).toString().padStart(2,'0') + '-' + now.getDate().toString().padStart(2,'0');
                    var timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
                    var invoiceContent = `<div id='invoice-capture-area' style='font-family:Tajawal,sans-serif;max-width:540px;margin:auto;background:linear-gradient(135deg,#f8fafc 0%,#e3f2fd 100%);border-radius:22px;padding:36px 28px 28px 28px;box-shadow:0 8px 32px rgba(0,0,0,0.13);position:relative;'>
                        <div style='position:absolute;top:24px;left:24px;'><img src='https://img.icons8.com/color/48/000000/paid-bill.png' style='width:38px;height:38px;'></div>
                        <div style='text-align:center;font-size:2.1rem;font-weight:900;color:#0054d7;margin-bottom:8px;'>فاتورة شراء</div>
                        <div style='display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;font-size:1.05rem;color:#888;margin-bottom:10px;'>
                            <span style='margin-bottom:4px;'>رقم الفاتورة: <b style="color:#0054d7;">${invoiceId}</b></span>
                            <span>${dateStr} &nbsp; ${timeStr}</span>
                        </div>
                        <div style='font-size:1.13rem;margin-bottom:8px;'><b>المتجر:</b> <span style='color:#0054d7;'>${shopName}</span></div>
                        <div style='font-size:1.13rem;margin-bottom:8px;'><b>اسم العميل:</b> <span style='color:#0054d7;'>${cardHolderVal}</span></div>
                        <div style='font-size:1.13rem;margin-bottom:14px;'><b>آخر 4 أرقام من البطاقة:</b> <span style='color:#0054d7;'>${last4}</span></div>
                        <div style='width:100%;overflow-x:auto;'>
                            <table style='width:100%;border-collapse:collapse;margin-bottom:18px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.04);'>
                                <thead><tr style='background:#e3f2fd;color:#0054d7;font-weight:bold;'><th style='padding:10px 8px;border:1px solid #e3f2fd;'>المنتج</th><th style='padding:10px 8px;border:1px solid #e3f2fd;'>السعر</th><th style='padding:10px 8px;border:1px solid #e3f2fd;'>الكمية</th><th style='padding:10px 8px;border:1px solid #e3f2fd;'>الإجمالي</th></tr></thead>
                                <tbody>
                                    ${cart.map(p => `<tr><td style='padding:8px 6px;border:1px solid #f0f0f0;'>${p.name}</td><td style='padding:8px 6px;border:1px solid #f0f0f0;'>${p.price} شيكل</td><td style='padding:8px 6px;border:1px solid #f0f0f0;'>${p.quantity}</td><td style='padding:8px 6px;border:1px solid #f0f0f0;'>${p.price * p.quantity} شيكل</td></tr>`).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div style='text-align:left;font-size:1.25rem;font-weight:bold;color:#198754;margin-top:10px;'>الإجمالي: ${total} شيكل</div>
                        <div style='text-align:center;font-size:1.05rem;color:#aaa;margin-top:22px;'>شكرًا لتسوقكم معنا!</div>
                    </div>`;
                    var tempDiv = document.createElement('div');
                    tempDiv.innerHTML = invoiceContent;
                    document.body.appendChild(tempDiv);
                    var captureArea = tempDiv.querySelector('#invoice-capture-area');
                    function downloadImage() {
                        html2canvas(captureArea, {backgroundColor: null, scale: 2}).then(function(canvas) {
                            var link = document.createElement('a');
                            link.download = 'فاتورة-شراء.png';
                            link.href = canvas.toDataURL('image/png');
                            link.click();
                            if(tempDiv && tempDiv.parentNode) tempDiv.parentNode.removeChild(tempDiv);
                        });
                    }
                    if (typeof html2canvas === 'undefined') {
                        var script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
                        script.onload = downloadImage;
                        document.body.appendChild(script);
                    } else {
                        downloadImage();
                    }
                };
            }, 400);
        };
    });
});
if (!window.__cardInputListenerAdded) {
    document.addEventListener('input', function(e) {
        if(e.target && e.target.id === 'card-number-input') {
            e.target.value = e.target.value.replace(/[^\d]/g, '').slice(0,16);
        }
    });
    window.__cardInputListenerAdded = true;
}
</script>
@endsection
