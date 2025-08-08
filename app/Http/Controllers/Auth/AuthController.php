<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return response()->view('auth.login');
    }
    
    public function showMerchantRegister()
    {
        return response()->view('auth.merchant-register');
    }
    
    public function merchantRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants',
            'address' => 'required|string|max:255',
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

        $merchant = new \App\Models\Merchant();
        $merchant->name = $request->input('name');
        $merchant->email = $request->input('email');
        $merchant->address = $request->input('address');
        $merchant->password = Hash::make($request->input('password'));
        $saved = $merchant->save();

        if ($saved) {
            event(new Registered($merchant));
            
            return redirect()->route('show-login')->with([
                'status' => true,
                'icon' => 'success',
                'message' => 'تم إنشاء حسابك كتاجر بنجاح! يرجى تسجيل الدخول وتفعيل بريدك الإلكتروني.'
            ]);
        }

        return redirect()->back()->with([
            'status' => false,
            'icon' => 'error',
            'message' => 'حدث خطأ أثناء إنشاء الحساب. يرجى المحاولة مرة أخرى.'
        ]);
    }
    
    public function showVerificationPage()
    {
        return view('auth.emailverification');
    }
    
    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::guard('merchant')->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('controlMerchant');
        }
        
        $user->sendEmailVerificationNotification();
        
        return back()->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم إرسال رابط التحقق من جديد، يرجى التحقق من بريدك الإلكتروني.'
        ]);
    }
    
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        
        return redirect()->route('controlMerchant')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم تأكيد بريدك الإلكتروني بنجاح!'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => "required|email",
            'password' => 'required|string',
        ]);

        $guards = ['admin', 'merchant'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                session(['active_guard' => $guard]);
                $request->session()->regenerate();

                return match ($guard) {
                    'admin' => redirect()->route('controlMerchant'),
                    'merchant' => redirect()->route('controlMerchant'),
                    default => redirect('/'),
                };
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        $guard = session('guard:merchant');
        auth($guard)->logout();
        $request->session()->invalidate();
        session()->remove('session');
        return redirect()->route('Liquidity.home');
    }

    public function editPassword()
    {
        $user = auth('merchant')->user() ?? auth('admin')->user();
        return response()->view('auth.changePassword', ['data' => $user]);
    }

    public function updatePassword(Request $request)
    {
        $user = auth('merchant')->user() ?? auth('admin')->user();
        $validation = $request->validate([
            'password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->symbols()
                    ->letters()
                    ->numbers()
                    ->uncompromised()
            ],
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        Mail::to($user->email)->send(new changePassword($user));

        return redirect()->route('controlMerchant')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ]);
    }

    public function forgotPassword()
    {
        return response()->view('auth.forgot-password');
    }

    public function sendResetEamil(request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|exists:merchants,email',
        ]);
        if ($validation) {
            $status = FacadesPassword::broker('merchants')->sendResetLink($request->only('email'));
            return $status == FacadesPassword::RESET_LINK_SENT
                ? redirect()->back()->with([
                    'status' => true,
                    'icon' => true ? 'success' : '',
                    'message' => true ? __($status) : ''
                ])
                : redirect()->back()->with([
                    'status' => false,
                    'icon' => false ? 'error' : '',
                    'message' => false ? __($status) : ''
                ]);
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return response()->view('auth.recover-password', [
            'token' => $token,
            'email' => $request->input('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validation = $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:password_reset_tokens,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->symbols() 
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->uncompromised()
            ],
        ]);

        if ($validation) {
            $status = FacadesPassword::broker('merchants')->reset($request->only(['email', 'token', 'password', 'password_confirmation']), function ($merchant, $password) {
                $merchant->forceFill(['password' => Hash::make($password)]);
                $merchant->save();
                event(new PasswordReset($merchant));
            });
            return $status == FacadesPassword::PASSWORD_RESET
                ? redirect()->route('login')->with([
                    'status' => true,
                    'icon' => true ? 'success' : 'error',
                    'message' =>  true ? "تمت تعيين كلمة مرور بنجاح قم بتسجيل الدخول" : "لم يتم التعديل يرجى التحقق من البيانات"
                ])
                : redirect()->back()->with([
                    'status' => false,
                    'icon' => false ? 'error' : 'success',
                    'message' => false ? __($status) : ''
                ]);
        } else {
            return redirect()->back()->with([
                'status' => false,
                'icon' => false ? 'error' : 'success',
                'message' => false ? '-----' : ''
            ]);
        }
    }
}
