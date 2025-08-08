<?php

namespace App\Http\Controllers;

use App\Models\branch;
use App\Models\merchant;
use App\Models\PaymentMethod;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(product::class, 'product');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('merchant')->user() ?? auth('admin')->user();

        if ($user instanceof Merchant) {
            $products = Product::with(['branch.shop', 'paymentMethods'])
                ->when($user instanceof Merchant, function ($query) use ($user) {
                    return $query->where('merchant_id', $user->id);
                })
                ->get();
        } else {
            $products = Product::with(['shop', 'paymentMethods'])->get();
        }

        return response()->view('MerchantControlPanel.my-product', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth('merchant')->check()) {
            Auth::shouldUse('merchant');
        } elseif (auth('admin')->check()) {
            Auth::shouldUse('admin');
        }

        $user = auth()->user();

        if (!$user instanceof merchant) {
            return redirect()->route('login')->with('message', 'يجب تسجيل الدخول كتاجر لرفع المنتجات');
        }

        $shops = $user->shops;
        $paymentMethods = PaymentMethod::where('merchant_id', $user->id)->get();
        $branches = branch::where('merchant_id', $user->id)->with('shop')->get();

        return view('MerchantControlPanel.uploadProduct', [
            'shops' => $shops,
            'paymentMethod' => $paymentMethods,
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $merchant = auth('merchant')->user();

        if (!$merchant) {
            return redirect()->back()->with([
                'status' => false,
                'icon' => 'error',
                'message' => 'لا يمكنك إنشاء منتج، هذه الصلاحية مخصصة للتاجر فقط.'
            ]);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0.01',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif',
            'shop_id' => 'required|exists:shops,id',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'exists:payment_methods,id',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        $merchant = auth('merchant')->user();
        $product = new product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->merchant_id = $merchant->id;
        $shopId = $request->input('shop_id');
        if ($shopId) {
            $product->shop_id = $shopId;
        }


        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->store('products', ['disk' => 'public']);
            $product->image = $imageName;
        }
        $saved = $product->save();

        $product->paymentMethods()->sync($request->payment_methods);

        if ($shopId) {
            $product->shops()->syncWithoutDetaching([$shopId]);
        }
        if ($request->filled('branch_ids')) {
            $product->branches()->sync($request->branch_ids);
        } else {
            $product->branches()->detach();
        }
        return redirect()->back()->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' =>  $saved ? "تمت حفظ البيانات بنجاح" : " !حدث خطأ"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
        $user = auth()->user();
        $merchant = auth('merchant')->user();
        $shops = $merchant->shops;
        $branches = branch::whereIn('shop_id', $shops->pluck('id'))->get();
        $paymentMethods = PaymentMethod::where('merchant_id', $user->id)->get();

        return response()->view('MerchantControlPanel.updateProduct', ['product' => $product, 'shops' => $shops, 'branches' => $branches, 'paymentMethod' => $paymentMethods]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0.01',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'shop_ids' => 'required|array',
            'shop_ids.*' => 'exists:shops,id',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'exists:payment_methods,id',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $merchant = auth('merchant')->user();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->merchant_id = $merchant->id;


        if ($request->hasFile('image')) {
            if (!is_null($product->image)) {
                if (Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            }
            $imageFile = $request->file('image');
            $name = $imageFile->store('products', ['disk' => 'public']);
            $product->image = $name;
        }
        $saved = $product->save();
        $product->shops()->sync($request->shop_ids);
        $product->paymentMethods()->sync($request->payment_methods);
        $product->branches()->sync($request->branch_ids ?? []);
        return redirect()->back()->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' =>  $saved ? "تمت حفظ البيانات بنجاح" : " !حدث خطأ"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, product $product)
    {
        $shop_id = $request->input('shop_id');
        $branch_id = $request->input('branch_id');
        $deleted = false;

        if ($branch_id) {
            $product->branches()->detach($branch_id);
        } elseif ($shop_id) {
            $product->shops()->detach($shop_id);
        } else {
            $product->shops()->detach();
            $product->branches()->detach();
            $product->paymentMethods()->detach();
            $deleted = $product->delete();
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        if ($product->shops()->count() == 0 && $product->branches()->count() == 0) {
            $product->paymentMethods()->detach();
            $deleted = $product->delete();
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with([
            'status' => true,
            'icon' => 'success',
            'message' =>  "تم حذف المنتج بنجاح"
        ]);
    }
}