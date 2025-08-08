<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Str;

class AdminShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('can:delete,shop')->only('destroy');
    }

    public function show(Shop $shop)
    {
        if (request()->ajax()) {
            $shop->load(['products.paymentMethods', 'branches', 'merchant']);
            $products = [];
            $payments = [];
            foreach ($shop->products as $product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image_url' => $product->image ? asset('storage/' . $product->image) : null,
                ];
                $payments[$product->id] = $product->paymentMethods->pluck('name')->toArray();
            }
            $shopData = [
                'id' => $shop->id,
                'name' => $shop->name,
                'description' => $shop->description,
                'phone' => $shop->phone,
                'latitude' => $shop->latitude,
                'longitude' => $shop->longitude,
                'image_url' => $shop->image ? asset('storage/' . $shop->image) : asset('images/default-shop.png'),
                'merchant' => $shop->merchant ? $shop->merchant->name : null,
                'branches_count' => $shop->branches ? $shop->branches->count() : 0,
                'email' => $shop->email,
                'activity' => $shop->activity,
                'created_at' => $shop->created_at->format('Y-m-d'),
            ];
            return response()->json([
                'success' => true,
                'shop' => $shopData,
                'products' => $products,
                'payments' => $payments,
            ]);
        }
        return view('MerchantControlPanel.admin-shop-show', compact('shop'));
    }
    public function index(Request $request)
    {
        $query = Shop::query()->with('merchant');

        // بحث بالاسم فقط
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%$q%") ;
        }
        // تصفية حسب الحالة
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        $shops = $query->orderByDesc('created_at')->paginate(15);
        return view('MerchantControlPanel.admin-shops', compact('shops'));
    }

    public function toggle(Shop $shop)
    {
        $shop->is_active = !$shop->is_active;
        $shop->save();
        return back()->with('status', 'تم تحديث حالة المحل بنجاح!');
    }

    // حذف المحل نهائياً
    public function destroy(Request $request, Shop $shop)
    {
        $this->authorize('delete', $shop);

        try {
            $shop->delete();
            return redirect()->back()->with([
                'status' => true,
                'icon' => 'success',
                'message' => 'تم حذف المحل بنجاح!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => false,
                'icon' => 'error',
                'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()
            ]);
        }
    }
}
