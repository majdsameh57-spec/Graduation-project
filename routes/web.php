<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function() {
        $shopsCount = \App\Models\shop::count();
        $branchesCount = \App\Models\branch::count();
        $activeMerchantsCount = \App\Models\merchant::count();
        $productsCount = \App\Models\product::count();
        $shopsPerMonth = [ 'labels' => [], 'data' => [] ];
        $shops = \App\Models\shop::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $months = [1=>'يناير',2=>'فبراير',3=>'مارس',4=>'ابريل',5=>'مايو',6=>'يونيو',7=>'يوليو',8=>'اغسطس',9=>'سبتمبر',10=>'اكتوبر',11=>'نوفمبر',12=>'ديسمبر'];
        foreach($months as $num=>$name) {
            $shopsPerMonth['labels'][] = $name;
            $shopsPerMonth['data'][] = $shops->firstWhere('month', $num)->count ?? 0;
        }
        $recentActivities = collect();
        $recentMerchants = \App\Models\merchant::orderBy('created_at', 'desc')->take(3)->get();
        foreach($recentMerchants as $merchant) {
            $recentActivities->push([
                'type' => 'merchant',
                'name' => $merchant->name,
                'created_at' => $merchant->created_at
            ]);
        }
        $recentProducts = \App\Models\product::orderBy('created_at', 'desc')->take(3)->get();
        foreach($recentProducts as $product) {
            $recentActivities->push([
                'type' => 'product',
                'name' => $product->name,
                'created_at' => $product->created_at
            ]);
        }
        $recentActivities = $recentActivities->sortByDesc('created_at')->take(5)->values();
        $recentShops = \App\Models\shop::with('merchant')->orderBy('created_at', 'desc')->take(5)->get();
        $recentProducts = \App\Models\product::with('shop')->orderBy('created_at', 'desc')->take(5)->get();
        return view('MerchantControlPanel.admin-dashboard', compact(
            'shopsCount', 'branchesCount', 'activeMerchantsCount', 'productsCount',
            'shopsPerMonth', 'recentActivities', 'recentShops', 'recentProducts'
        ));
    })->name('admin.dashboard');
    Route::get('/admin/shops', [\App\Http\Controllers\AdminShopController::class, 'index'])->name('admin.shops');
    Route::patch('/admin/shops/{shop}/toggle', [\App\Http\Controllers\AdminShopController::class, 'toggle'])->name('shops.toggle');
    Route::delete('/admin/shops/{shop}', [\App\Http\Controllers\AdminShopController::class, 'destroy'])->name('admin.shops.destroy');
    Route::get('/admin/products', [\App\Http\Controllers\AdminProductController::class, 'index'])->name('admin.products');
    Route::delete('/admin/products/{product}', [\App\Http\Controllers\AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/shops/{shop}', [\App\Http\Controllers\AdminShopController::class, 'show'])->name('admin.shops.show');
});

Route::prefix('your-liquidity')->group(function () {
    Route::view('/cart', 'Liquidity.cart')->name('cart.show');
    Route::get('/home', [ShopController::class, 'featuredShops'])->name('home');
    Route::get('/', [ShopController::class, 'home'])->name('Liquidity.home');
    Route::view('/login-store', 'Liquidity.loginStore')->name('Liquidity.login-store');
    Route::view('/loading-data', 'Liquidity.loadingData')->name('Liquidity.load-data');
    Route::view('/contact', 'Liquidity.contactus')->name('Liquidity.contact');
    Route::get('/shops/download', [ShopController::class, 'downloadShops'])->name('shops.download');
    Route::resource('/shops', ShopController::class);
    Route::get('/All-Shops', [ShopController::class, 'allShops'])->name('all.shops');
    Route::post('/contact', [contactController::class, 'send'])->name('contact.send');
    Route::get('/auth.merchant-register',[MerchantController::class, 'createNewMerchant'])->name('auth.merchant-register');
    Route::post('/merchants-new-save',[MerchantController::class, 'storeNewMerchant'])->name('merchant.new.save');
});

Route::prefix('your-liquidity')->middleware('guest:merchant,admin,web')->group(function() {
    Route::get('/login',[ AuthController::class, 'showLogin'])->name('show-login');
    Route::post('/login',[ AuthController::class, 'login'])->name('login');
    Route::get('/user-login', [\App\Http\Controllers\Regular\UserController::class, 'showLogin'])->name('user.login');
    Route::post('/user-login', [\App\Http\Controllers\Regular\UserController::class, 'login'])->name('user.login.submit');
    Route::get('/user-register', [\App\Http\Controllers\Regular\UserController::class, 'showRegister'])->name('user.register');
    Route::post('/user-register', [\App\Http\Controllers\Regular\UserController::class, 'register'])->name('user.register.submit');
    Route::get('/merchant-register', [MerchantController::class, 'showRegister'])->name('merchant.register');
    Route::post('/merchant-register', [MerchantController::class, 'storeNewMerchant'])->name('merchant.register.submit');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetEamil'])->name('password.email');
    Route::get('/forgot-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::prefix('your-liquidity')->middleware('auth:admin,merchant')->group(function () {
    Route::resource('/roles', roleController::class);
    Route::resource('/permissions', permissionController::class);
    Route::put('roles/permissions/edit', [roleController::class, 'updateRolePermission'])->name('roles.update-permission');
    Route::get('/admins/{admin}/permissions/edit', [AdminController::class, 'editUserPermission'])->name('admins.permissions.edit');
    Route::post('/admins/{admin}/permissions/update', [AdminController::class, 'updateUserPermission'])->name('admins.permissions.update');
    Route::get('/merchants/{merchant}/permissions/edit', [MerchantController::class, 'editMerchantPermission'])->name('merchants.permissions.edit');
    Route::post('/merchants/{merchant}/permissions/update', [MerchantController::class, 'updateMerchantPermission'])->name('merchants.permissions.update');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit-profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('update-profile');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');

    Route::get('/control-merchant', function () {
        if (auth('merchant')->check()) {
            $user = auth('merchant')->user();
            $shops = $user->shops()->withCount(['branches', 'products'])->get();
            $shopsCount = $shops->count();
            $branches = $user->branches()->with('shop')->get();
            foreach ($branches as $branch) {
                $branch->shop_name = $branch->shop->name ?? '';
            }
            $branchesCount = $branches->count();
            $productsCount = $shops->sum('products_count');
            $productsPerShop = [
                'labels' => $shops->pluck('name')->toArray(),
                'data' => $shops->pluck('products_count')->toArray(),
            ];
            $averageProductsPerShop = $shopsCount > 0 ? round($shops->sum('products_count') / $shopsCount, 2) : 0;
            $topShopByProducts = $shops->sortByDesc('products_count')->first();
            return view('MerchantControlPanel.dashboard', compact(
                'shops',
                'shopsCount',
                'branches',
                'branchesCount',
                'productsCount',
                'productsPerShop',
                'averageProductsPerShop',
                'topShopByProducts',
            ));
        } elseif (auth('admin')->check()) {
            $shopsCount = \App\Models\shop::count();
            $branchesCount = \App\Models\branch::count();
            $activeMerchantsCount = \App\Models\merchant::count();
            $productsCount = \App\Models\product::count();
            $shopsPerMonth = [ 'labels' => [], 'data' => [] ];
            $shops = \App\Models\shop::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $months = [1=>'يناير',2=>'فبراير',3=>'مارس',4=>'ابريل',5=>'مايو',6=>'يونيو',7=>'يوليو',8=>'اغسطس',9=>'سبتمبر',10=>'اكتوبر',11=>'نوفمبر',12=>'ديسمبر'];
            foreach($months as $num=>$name) {
                $shopsPerMonth['labels'][] = $name;
                $shopsPerMonth['data'][] = $shops->firstWhere('month', $num)->count ?? 0;
            }
            $recentActivities = collect();
            $recentMerchants = \App\Models\merchant::orderBy('created_at', 'desc')->take(3)->get();
            foreach($recentMerchants as $merchant) {
                $recentActivities->push([
                    'type' => 'merchant',
                    'name' => $merchant->name,
                    'created_at' => $merchant->created_at
                ]);
            }
            $recentProducts = \App\Models\product::orderBy('created_at', 'desc')->take(3)->get();
            foreach($recentProducts as $product) {
                $recentActivities->push([
                    'type' => 'product',
                    'name' => $product->name,
                    'created_at' => $product->created_at
                ]);
            }
            $recentActivities = $recentActivities->sortByDesc('created_at')->take(5)->values();
            $recentShops = \App\Models\shop::with('merchant')->orderBy('created_at', 'desc')->take(5)->get();
            $recentProducts = \App\Models\product::with('shop')->orderBy('created_at', 'desc')->take(5)->get();
            return view('MerchantControlPanel.admin-dashboard', compact(
                'shopsCount', 'branchesCount', 'activeMerchantsCount', 'productsCount',
                'shopsPerMonth', 'recentActivities', 'recentShops', 'recentProducts'
            ));
        } else {
            abort(403, 'Unauthorized');
        }
    })->name('controlMerchant');
    Route::view('/store-data', 'MerchantControlPanel.storeData')->name('store-data');
    Route::view('/myProduct', 'MerchantControlPanel.my-product')->name('myProduct');
    Route::view('/branches', 'MerchantControlPanel.branches')->name('branches');
    Route::view('/uploadProduct', 'MerchantControlPanel.uploadProduct')->name('uploadProduct');
    Route::post('/branches/store', [\App\Http\Controllers\ShopController::class, 'storeBranch'])->name('branches.store');
    Route::post('/branches/custom-store', [\App\Http\Controllers\ShopController::class, 'storeBranch'])->name('branches.custom-store');
    Route::resource('/branches', BranchController::class);
    Route::delete('/branches/{branch}/products/{product}', [\App\Http\Controllers\BranchController::class, 'detachProduct'])
        ->name('branches.products.detach');
    Route::resource('/products', ProductController::class);
    Route::resource('/admins', AdminController::class);
    Route::resource('/paymentMethods', PaymentMethodController::class);
    Route::resource('/merchants', MerchantController::class);
    Route::get('/password/edit',[ AuthController::class, 'editPassword'])->name('edit-password');
    Route::put('/password/update',[ AuthController::class, 'updatePassword'])->middleware('throttle:3,3')->name('update-password');
    Route::get('/logout',[ AuthController::class, 'logout'])->name('logout');
    Route::get('/merchant/dashboard', [\App\Http\Controllers\MerchantController::class, 'dashboard'])
        ->name('merchant.dashboard');
});

Route::prefix('your-liquidity')->middleware('auth:web')->group(function () {
    Route::get('/user/logout', [\App\Http\Controllers\Regular\UserController::class, 'logout'])->name('user.logout');
    Route::get('/user/profile', [\App\Http\Controllers\Regular\UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/profile/edit', [\App\Http\Controllers\Regular\UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile/update', [\App\Http\Controllers\Regular\UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/nearby-shops', [\App\Http\Controllers\Regular\UserController::class, 'getNearbyShops'])->name('user.nearby.shops');
    Route::get('/shops/{shop}/products', [\App\Http\Controllers\ShopController::class, 'productsApi']);
});

Route::get('/your-liquidity/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');
Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');
