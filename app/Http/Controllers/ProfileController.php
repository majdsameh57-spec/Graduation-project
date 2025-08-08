<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::guard('admin')->check() 
            ? Auth::guard('admin')->user() 
            : Auth::guard('merchant')->user();
        
        // Initialize counts and arrays
        $shopCount = 0;
        $productCount = 0;
        $merchantCount = 0;
        $shops = [];

        // If merchant is logged in
        if (Auth::guard('merchant')->check()) {
            // Get shops owned by the merchant
            $shops = \App\Models\Shop::where('merchant_id', $user->id)->get();
            
            // Count shops
            $shopCount = count($shops);
            
            // Count products across all shops
            $productCount = \App\Models\Product::whereIn('shop_id', function($query) use ($user) {
                $query->select('id')->from('shops')->where('merchant_id', $user->id);
            })->count();
        }
        
        // If admin is logged in
        if (Auth::guard('admin')->check()) {
            $shopCount = \App\Models\Shop::count();
            $merchantCount = \App\Models\Merchant::count();
            $productCount = \App\Models\Product::count();
            
            // Get all shops for admin
            $shops = \App\Models\Shop::all();
        }
            
        return view('MerchantControlPanel.profile', compact('user', 'shopCount', 'productCount', 'merchantCount', 'shops'));
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::guard('admin')->check() 
            ? Auth::guard('admin')->user() 
            : Auth::guard('merchant')->user();
            
        return view('MerchantControlPanel.edit-profile', compact('user'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::guard('admin')->check() 
            ? Auth::guard('admin')->user() 
            : Auth::guard('merchant')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Show the form for editing the user's password.
     *
     * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        return view('MerchantControlPanel.edit_password');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::guard('admin')->check() 
            ? Auth::guard('admin')->user() 
            : Auth::guard('merchant')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
}