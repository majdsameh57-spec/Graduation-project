<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'governorate',
        'neighborhood',
        'latitude',
        'longitude',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    
    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
