<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected static function booted()
    {
        static::deleting(function ($shop) {
            $shop->products()->each(function ($product) {
                $product->delete();
            });
        });
    }
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'phone', 'email', 'password', 'merchant_id', 'activity', 'latitude', 'longitude', 'image'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id');
    }

    public function mainBranch()
    {
        return $this->hasOne(Branch::class)->where('is_main', true);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }
}
