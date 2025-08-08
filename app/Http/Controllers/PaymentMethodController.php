<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $merchant = auth('merchant')->user();
        $query = PaymentMethod::where('merchant_id', $merchant->id);
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('name', 'like', "%$q%");
        }
        $paymentMethods = $query->get();
        return view('MerchantControlPanel.paymentMethod', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merchant = auth('merchant')->user();
        $paymentMethods = \App\Models\PaymentMethod::where('merchant_id', $merchant->id)->get();  
        return view('MerchantControlPanel.paymentMethod', compact('paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:payment_methods,name,NULL,id,merchant_id,' . auth('merchant')->id(),
        ]);

        $merchant = auth('merchant')->user();

        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $request->input('name');
        $paymentMethod->merchant_id = $merchant->id;
        $saved = $paymentMethod->save();

        return redirect()->back()->with([
            'status' => $saved,
            'icon' => $saved ? 'success' : 'error',
            'message' => $saved ? "تمت حفظ البيانات بنجاح" : "حدث خطأ!",
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('paymentMethods.index')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم حذف طريقة الدفع بنجاح'
        ]);
    }
}
