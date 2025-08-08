<?php

namespace App\Http\Controllers;

use App\Exports\ShopsExport;
use App\Models\branch;
use App\Models\merchant;
use App\Models\shop;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    public function home()
    {
        $shopes = \App\Models\shop::withCount('products')
            ->with(['branches', 'merchant'])
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take(4)
            ->get();
        return view('Liquidity.home', compact('shopes'));
    }
    public function index()
    {
        if (auth('merchant')->check()) {
            Auth::shouldUse('merchant');
        }

        $merchant = auth()->user();

        if (!$merchant instanceof \App\Models\merchant) {
            return redirect()->route('login')->with('message', 'يجب تسجيل الدخول كتاجر لعرض المحلات');
        }

        $shops = $merchant->shops()->with(['products', 'branches.products'])->get();

        return response()->view('shop.index', ['shops' => $shops]);
    }

    public function allShops()
    {
    $shops = Shop::with(['branches.locationRelation', 'location'])->get();
    $branches = Branch::with(['shop', 'locationRelation'])->get();
        $governorates = [
            'الشمال',
            'غزة',
            'الوسطى',
            'خانيونس',
            'رفح',
        ];

    $neighborhoods = [
        'الشمال' => [
            'جباليا البلد',
            'مخيم جباليا',
            'بيت لاهيا',
            'بيت حانون',
            'مشروع بيت لاهيا',
            'تل الزعتر',
            'الصفطاوي',
            'عزبة عبد ربه',
            'السلاطين',
            'المنطقة الصناعية بيت حانون',
        ],

        'غزة' => [
            'الرمال الشمالي',
            'الرمال الجنوبي',
            'تل الهوى',
            'الشيخ رضوان',
            'الزيتون',
            'الدرج',
            'الشجاعية',
            'الصبرة',
            'الشيخ عجلين',
            'المنطقة الصناعية',
            'التفاح',
            'النصر',
            'الميناء',
            'المصدر',
            'مخيم الشاطئ',
        ],

        'الوسطى' => [
            'النصيرات',
            'مخيم النصيرات',
            'الزوايدة',
            'دير البلح',
            'مخيم دير البلح',
            'المغازي',
            'البريج',
            'مخيم البريج',
            'المصدر',
            'الزهراء',
            'وادي السلقا',
        ],

        'خانيونس' => [
            'خان يونس البلد',
            'المعسكر الغربي',
            'بني سهيلا',
            'القرارة',
            'خزاعة',
            'عبسان الكبيرة',
            'عبسان الصغيرة',
            'المنطقة الشرقية',
            'المنطقة الغربية',
            'الحي النمساوي',
            'الحي الياباني',
            'حي الأمل',
            'المنطقة الصناعية خانيونس',
        ],

        'رفح' => [
            'رفح البلد',
            'تل السلطان',
            'الشابورة',
            'جنوب رفح',
            'حي السلام',
            'حي النصر',
            'حي الجنينة',
            'يبنا',
            'البرازيل',
            'خربة العدس',
            'البيوك',
            'مخيم رفح',
            'الحي السعودي',
            'الحي الإداري',
            'الشوكة',
            'المطار',
        ],
    ];

        return view('shop.allShops', compact('shops', 'branches', 'governorates', 'neighborhoods'));
    }

    public function create()
    {
        $user = auth('merchant')->user() ?? auth('admin')->user();

        if (!$user) {
            return redirect()->route('login')->with('message', 'يجب تسجيل الدخول أولاً');
        }

        if (auth('merchant')->check()) {
            Auth::shouldUse('merchant');
        } elseif (auth('admin')->check()) {
            Auth::shouldUse('admin');
        }

        $branches = $user->branches ?? [];

        return response()->view('MerchantControlPanel.storeData', [
            'merchant' => auth('merchant')->user(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'activity' => 'required|string',
            'description' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'password' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif',
            'other_activity' => 'nullable|string',
        ]);

        if (
            !$request->input('governorate') ||
            !$request->input('neighborhood') ||
            !$request->input('latitude') ||
            !$request->input('longitude')
        ) {
            return redirect()->back()->with([
                'status' => false,
                'icon' => 'error',
                'message' => "يجب تحديد الموقع (المحافظة والحي) من الخريطة"
            ]);
        }

        $merchant = auth('merchant')->user();

        $activity = $request->input('activity');
        if ($activity === 'other') {
            $activity = $request->input('other_activity');
        }

        $shop = new shop();
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->phone = $request->input('phone');
        $shop->email = $request->input('email');
        $shop->password = Hash::make($request->input('password'));
        $shop->merchant_id = $merchant->id;
        $shop->activity = $activity;
        $shop->latitude = $request->input('latitude');
        $shop->longitude = $request->input('longitude');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shops', 'public');
            $shop->image = $path;
        }
        $shop->save();

        $neighborhood = $request->input('neighborhood');
        $neighborhoodsMap = [
            "Ash Shuja'iyeh Ijdeedeh" => "الشجاعية",
            "Ash Shuja'iyeh" => "الشجاعية",
            "Rimal" => "الرمال",
        ];
        if (isset($neighborhoodsMap[$neighborhood])) {
            $neighborhood = $neighborhoodsMap[$neighborhood];
        }

        $location = new Location();
        $location->shop_id = $shop->id;
        $location->governorate = $request->input('governorate');
        $location->neighborhood = $neighborhood;
        $location->latitude = $request->input('latitude');
        $location->longitude = $request->input('longitude');
        $location->save();

        return redirect()->back()->with([
            'status' => true,
            'icon' => 'success',
            'message' => "تمت حفظ البيانات بنجاح"
        ]);
    }

    public function show($id)
    {
        $shop = Shop::with(['mainBranch', 'branches'])->findOrFail($id);

        $branches = $shop->branches;

        $hasBranches = $branches->count() > 0;

        return view('Liquidity.shops-show', compact('shop', 'branches', 'hasBranches'));
    }
    public function edit(shop $shop)
    {
        //
    }

    public function update(Request $request, Shop $shop) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'activity' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'governorate' => 'nullable|string',
            'neighborhood' => 'nullable|string',
        ]);
        if ($request->filled('custom_activity')) {
            $data['activity'] = $request->input('custom_activity');
        }
        $shop->update($data);
        if ($request->hasFile('image')) {
            $shop->image = $request->file('image')->store('shops', 'public');
            $shop->save();
        }
        return redirect()->back()->with('success', 'تم تحديث بيانات المتجر بنجاح');
    }

    public function destroy(shop $shop)
    {
        try {
            $shop->delete();
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('shops.index')->with('success', 'تم حذف المحل بنجاح');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'فشل الحذف']);
            }
            return redirect()->back()->with('error', 'فشل الحذف');
        }
    }

    public function downloadShops()
    {
        return Excel::download(new ShopsExport, 'shops.xlsx');
    }

    public function uploadProduct()
    {
        $merchant = auth('merchant')->user();
        $shops = $merchant->shops;
        $branches = branch::whereIn('shop_id', $shops->pluck('id'))->get();
                return view('MerchantControlPanel.uploadProduct', compact('shops', 'branches'));
    }

    public function storeBranch(Request $request)
    {

        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'location' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'governorate' => 'required',
            'neighborhood' => 'required',
            'phone_number' => 'required|string',
        ]);

        $branch = new Branch();
        $branch->name = $request->input('name');
        $branch->shop_id = $request->input('shop_id');
        $branch->location = $request->input('location');
        $branch->merchant_id = auth('merchant')->id();
        $branch->latitude = $request->input('latitude');
        $branch->longitude = $request->input('longitude');
        $branch->phone_number = $request->input('phone_number');
        $branch->save();

        $location = new Location();
        $location->shop_id = $branch->shop_id;
        $location->branch_id = $branch->id;
        $location->governorate = $request->input('governorate');
        $location->neighborhood = $request->input('neighborhood');
        $location->latitude = $request->input('latitude');
        $location->longitude = $request->input('longitude');
        $location->save();

        return redirect()->back()->with([
            'status' => true,
            'icon' => 'success',
            'message' => "تمت إضافة الفرع"
        ]);
    }

    public function productsApi(Request $request, $shopId)
    {
        $limit = $request->input('limit', 5);
        $shop = \App\Models\shop::findOrFail($shopId);
        $products = $shop->products()->orderBy('created_at', 'desc')->limit($limit)->get(['id', 'name', 'created_at']);
        return response()->json(['products' => $products]);
    }
}
