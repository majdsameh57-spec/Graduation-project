<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles;

    protected $guard_name = 'admin';
    protected $guarded = ['0']; 

}
