<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Merchant;
use App\Policies\MerchantPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\ShopPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Merchant::class => MerchantPolicy::class,
        \App\Models\Shop::class => \App\Policies\ShopPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        if (Auth::guard('merchant')->check()) {
            Auth::shouldUse('merchant');
        } elseif (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
        }
    }
}