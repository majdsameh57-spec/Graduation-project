<?php

namespace App\Http\Controllers;

use App\Models\branch;
use App\Models\merchant;
use Illuminate\Http\Request;

class BranchController extends Controller
{


    public function create()
    {
        $this->authorize('create', [branch::class]);
        $user = auth('admin')->user() ?? auth('merchant')->user();
        $branches = [];
        $shops = [];
        if ($user instanceof merchant) {
            $branches = branch::where('merchant_id', $user->id)->get();
            $shops = $user->shops;
        }
        return response()->view('MerchantControlPanel.branches', [
            'branches' => $branches,
            'shops' => $shops
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', [branch::class]);
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'location' => 'required|string|max:255',
            'address_details' => 'nullable|string',
            'phone_number' => 'required|string',
        ]);
        $merchant = auth('merchant')->user();
        $branch = new branch();
        $branch->location = $request->input('location');
        $branch->address_details = $request->input('address_details');
        $branch->phone_number = $request->input('phone_number');
        $branch->shop_id = $request->input('shop_id');
        $branch->merchant_id = $merchant->id;
        $branch->latitude = $request->input('latitude');
        $branch->longitude = $request->input('longitude');
        $saved = $branch->save();
        return redirect()->back()->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' =>  $saved ? "تمت حفظ البيانات بنجاح" : " !حدث خطأ"
        ]);
    }

    public function show($id)
    {
        $branch = Branch::findOrFail($id);
        $shop = $branch->shop;
        return view('MerchantControlPanel.branches-show', compact('branch', 'shop'));
    }

    public function destroy(branch $branch)
    {
        $this->authorize('delete', [branch::class]);
        $deleted = $branch->delete();
        return redirect()->back()->with([
            'status' => $deleted,
            'icon' => $deleted ? 'success' : 'error',
            'message' =>  $deleted ? "تم حذف البيانات بنجاح" : "لم يتم الحذف"
        ]);
    }

    public function detachProduct($branchId, $productId)
    {
        $branch = \App\Models\Branch::findOrFail($branchId);
        $branch->products()->detach($productId);
        return back()->with('status', true)->with('message', 'تم حذف المنتج من الفرع بنجاح');
    }
}

