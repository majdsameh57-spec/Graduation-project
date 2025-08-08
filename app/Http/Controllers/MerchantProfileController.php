<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantProfileController extends Controller
{

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['mobile'])) $user->mobile = $validated['mobile'];
        if (isset($validated['birth_date'])) $user->birth_date = $validated['birth_date'];
        $user->save();

        return redirect()->route('profile')->with('success', 'تم تحديث البيانات بنجاح');
    }

}