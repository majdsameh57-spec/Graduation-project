<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'product_shops');
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_products');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'payment_method_products');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    
    public function branches()
    {
        return $this->belongsToMany(branch::class, 'branch_product');
    }
}