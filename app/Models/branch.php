<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'phone_number', 'shop_id', 'merchant_id', 'latitude', 'longitude', 'address_details'
    ];

    public function shop()
    {
        return $this->belongsTo(\App\Models\shop::class, 'shop_id');
    }
    public function scopeMainBranch($query)
    {
        return $query->where('is_main', true);
    }

    public function scopeSubBranches($query)
    {
        return $query->where('is_main', false);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_product');
    }
    public function locationRelation()
    {
        return $this->hasOne(\App\Models\Location::class, 'branch_id', 'id');
    }
}
