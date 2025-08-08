<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = product::with('shop');
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        $products = $query->orderByDesc('id')->paginate(15);
        return view('MerchantControlPanel.admin-products', compact('products'));
    }

    public function destroy(Request $request, product $product)
    {
        try {
            $product->delete();
            return redirect()->back()->with([
                'status' => true,
                'icon' => 'success',
                'message' => 'تم حذف المنتج بنجاح!'
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
