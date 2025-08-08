<?php

namespace App\Http\Controllers\Regular;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function getNearbyShops(Request $request)
    {
        $user = Auth::guard('web')->user();
        $radius = $request->input('radius', 5);
        $userLat = $request->input('lat');
        $userLng = $request->input('lng');
        if (!$userLat || !$userLng) {
            return response()->json(['error' => 'يرجى تفعيل الموقع الجغرافي'], 422);
        }

        $shops = \App\Models\shop::all();
        $nearby = [];
        foreach ($shops as $shop) {
            if ($shop->latitude && $shop->longitude) {
                $distance = $this->haversineDistance($userLat, $userLng, $shop->latitude, $shop->longitude);
                if ($distance <= $radius) {
                    $nearby[] = [
                        'id' => $shop->id,
                        'name' => $shop->name,
                        'address' => $shop->address,
                        'distance' => round($distance, 2),
                        'image' => $shop->image,
                        'description' => $shop->description,
                    ];
                }
            }
        }
        return response()->json(['shops' => $nearby]);
    }

    public function showLogin()
    {
        return response()->view('auth.user-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => "required|email",
            'password' => 'required|string',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            if (empty($user->address)) {
                return redirect()->route('user.profile.edit')->with([
                    'status' => false,
                    'icon' => 'warning',
                    'message' => 'يرجى إدخال عنوانك لإكمال استخدام المنصة.'
                ]);
            }
            return redirect()->route('Liquidity.home');
        }

        return redirect()->back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ]);
    }

    public function showRegister()
    {
        return response()->view('auth.user-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->password = Hash::make($request->input('password'));
        $saved = $user->save();

        if ($saved) {
        return redirect()->route('user.login')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم إنشاء حسابك بنجاح! يرجى تسجيل الدخول.'
        ]);
        }

        return redirect()->back()->with([
            'status' => false,
            'icon' => 'error',
            'message' => 'حدث خطأ أثناء إنشاء الحساب. يرجى المحاولة مرة أخرى.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('Liquidity.home');
    }
    
    public function showVerificationPage()
    {
        return view('auth.emailverification');
    }
    
    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::guard('web')->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('Liquidity.home');
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
        
        return redirect()->route('Liquidity.home')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم تأكيد بريدك الإلكتروني بنجاح!'
        ]);
    }
    
    public function profile()
    {
        $user = Auth::guard('web')->user();
        return view('user.profile', compact('user'));
    }
    
    public function editProfile()
    {
        $user = Auth::guard('web')->user();
        return view('user.edit-profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->save();
        
        return redirect()->route('user.profile')->with([
            'status' => true,
            'icon' => 'success',
            'message' => 'تم تحديث بياناتك الشخصية بنجاح!'
        ]);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;
        return $distance;
    }
}
