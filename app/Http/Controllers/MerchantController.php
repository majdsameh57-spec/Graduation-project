<?php

namespace App\Http\Controllers;

use App\Models\merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(merchant::class);
    }
    
    public function index(Request $request)
    {
        if (auth('merchant')->check()) {
            Auth::shouldUse('merchant');
        } elseif (auth('admin')->check()) {
            Auth::shouldUse('admin');
        }
        $query = merchant::with('roles')->withCount('permissions');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $merchants = $query->get();
        return response()->view('merchant.index', ['merchants' => $merchants]);
    }

    
    public function create()
    {
        $this->authorize('create', [merchant::class]);
        return response()->view('merchant.create');
    }

    public function createNewMerchant()
    {
        return response()->view('merchant.create');
    }
    
    public function showRegister()
    {
        return response()->view('auth.merchant-register');
    }

    public function storeNewMerchant(request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchants,email',
            'mobile' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $merchants = new merchant();
        $merchants->name = $request->input('name');
        $merchants->email = $request->input('email');
        $merchants->mobile = $request->input('mobile');
        $merchants->password = Hash::make($request->input('password'));
        $saved = $merchants->save();
        
        if ($saved) {
            $defaultRole = Role::where('name', 'merchant')->first();
            if ($defaultRole) {
                $merchants->assignRole($defaultRole);
            }
            
        }
        
        return redirect()->route('show-login')->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' => $saved ? "تم إنشاء الحساب بنجاح" : "حدث خطأ أثناء إنشاء الحساب"
        ]);
    }


    public function store(Request $request)
    {
    }

    

    
    public function edit(merchant $merchant)
    {
        $this->authorize('update', [merchant::class]);
        if (auth('merchant')->check()) {
            Auth::shouldUse('merchant');
        } elseif (auth('admin')->check()) {
            Auth::shouldUse('admin');
        }
        $roles = Role::where('guard_name', 'merchant')->get();
        return response()->view('merchant.update', ['data' => $merchant, 'roles' => $roles]);
    }

    
    public function update(Request $request, merchant $merchant)
    {
        $this->authorize('update', [merchant::class]);
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'date' => 'required|date',
            'role_id' => 'nullable|numeric|exists:roles,id'
        ]);
        $merchant->name = $request->input('name');
        $merchant->email = $request->input('email');
        $merchant->mobile = $request->input('mobile');
        $merchant->birth_date = $request->input('date');
        $saved = $merchant->save();
        $role = Role::where('id', $request->input('role_id'))
            ->where('guard_name', 'merchant')
            ->first();

        if ($role) {
            $merchant->assignRole($role->name);
        }
        return redirect()->route('merchants.index')->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' =>  $saved ? "تمت تحديث البيانات بنجاح" : " !حدث خطأ"
        ]);
    }

    
    public function destroy(merchant $merchant)
    {
        $this->authorize('delete', [merchant::class]);
        $deletedCount = $merchant->delete();
        return redirect()->back()->with([
            'status' => true,
            'icon' => $deletedCount ? 'success' : 'error',
            'message' =>  $deletedCount ? "تم الحذف بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    public function editMerchantPermission(Request $request, merchant $merchant)
    {
        $this->authorize('editPermission', [merchant::class]);
        $role = $merchant->roles->first();
        if (!$role) {
            return redirect()->back()->with('error', 'المستخدم لا يمتلك دورًا.');
        }

        $rolePermissions = $role->permissions;
        $merchantPermissions = $merchant->permissions->pluck('id')->toArray();
        if (count($merchantPermissions)) {
            foreach ($merchantPermissions as $merchantPermission) {
                foreach ($rolePermissions as $rolePermission) {
                    if (in_array($rolePermission->id, $merchantPermissions)) {
                        $rolePermission->setAttribute('assigned', true);
                    } else {
                        $rolePermission->setAttribute('assigned', false);
                    }
                }
            }
        }
        return response()->view('merchant.merchantPermission', ['merchant' => $merchant, 'role' => $role, 'rolePermission' => $rolePermissions, 'merchantPermission' => $merchantPermissions]);
    }
    public function updateMerchantPermission(Request $request, merchant $merchant)
    {
        $this->authorize('updatePermission', [merchant::class]);
        $validator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission = Permission::findById($request->input('permission_id'), 'merchant');

        $hasDirectPermission = $merchant->permissions->contains('id', $permission->id);

        if ($hasDirectPermission) {
            $merchant->revokePermissionTo($permission);
        } else {
            $merchant->givePermissionTo($permission);
        }

        return response()->json(['status' => true, 'message' => 'Permission Updated']);
    }

    
    public function dashboard()
    {
        $merchantId = auth('merchant')->id();

        $shopsCount = \DB::table('shops')
            ->where('merchant_id', $merchantId)
            ->count();
        
        $branchesCount = \DB::table('branches')
            ->join('shops', 'branches.shop_id', '=', 'shops.id')
            ->where('shops.merchant_id', $merchantId)
            ->count();
        
        $productsCount = \DB::table('products')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->where('shops.merchant_id', $merchantId)
            ->count();
        
        $shops = \DB::table('shops')
            ->where('shops.merchant_id', $merchantId)
            ->select(
                'shops.id',
                'shops.name',
                \DB::raw('(SELECT COUNT(*) FROM branches WHERE branches.shop_id = shops.id) as branches_count'),
                \DB::raw('(SELECT COUNT(*) FROM products WHERE products.shop_id = shops.id) as products_count')
            )
            ->orderBy('shops.created_at', 'desc')
            ->get();
        
        $branches = \DB::table('branches')
            ->join('shops', 'branches.shop_id', '=', 'shops.id')
            ->where('shops.merchant_id', $merchantId)
            ->select(
                'branches.id',
                'branches.name',
                'branches.location',
                'shops.name as shop_name'
            )
            ->orderBy('branches.created_at', 'desc')
            ->get();
        
        $averageProductsPerShop = $shopsCount > 0 ? round($productsCount / $shopsCount, 1) : 0;
        
        $topShopByProducts = \DB::table('shops')
            ->where('shops.merchant_id', $merchantId)
            ->select(
                'shops.id',
                'shops.name',
                \DB::raw('(SELECT COUNT(*) FROM products WHERE products.shop_id = shops.id) as products_count')
            )
            ->orderBy('products_count', 'desc')
            ->first();
        
        $productsPerShop = $this->getProductsPerShopForChart($merchantId);

        return view('MerchantControlPanel.dashboard', compact(
            'shopsCount',
            'branchesCount',
            'productsCount',
            'shops',
            'branches',
            'averageProductsPerShop',
            'topShopByProducts',
            'productsPerShop'
        ));
    }

    
    private function getProductsPerShopForChart($merchantId)
    {
        $shops = \DB::table('shops')
            ->where('shops.merchant_id', $merchantId)
            ->select(
                'shops.id',
                'shops.name',
                \DB::raw('(SELECT COUNT(*) FROM products WHERE products.shop_id = shops.id) as products_count')
            )
            ->orderBy('products_count', 'desc')
            ->limit(10) 
            ->get();

        $labels = [];
        $data = [];

        foreach ($shops as $shop) {
            $labels[] = $shop->name;
            $data[] = $shop->products_count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function profile()
    {
        $merchant = auth('merchant')->user();
        return view('merchant.profile', compact('merchant'));
    }

    public function editProfile()
    {
        $merchant = auth('merchant')->user();
        return view('merchant.edit-profile', compact('merchant'));
    }
}