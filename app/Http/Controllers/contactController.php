<?php

namespace App\Http\Controllers;

use App\Mail\contactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class contactController extends Controller
{
    //
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::to('admin@example.com')->send(new contactUsMail($validated));

        return redirect()->back()->with([
            'status'=> true,
            'icon' => true ? 'success' : 'error',
            'message' =>  true ? "تمت ارسال الرسالة بنجاح" : "لم يتم الارسال يرجى التحقق من البيانات"
        ]);
    }
}
