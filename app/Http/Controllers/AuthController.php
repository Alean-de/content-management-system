<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{   
    public function dashboard()
    {
        return view('administrator.dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required']
        ]);

        $throttleKey = Str::lower($request->identity) . '|' . $request->ip();

        if(RateLimiter::tooManyAttempts($throttleKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'identity'  =>  "Terlalu banyak percobaan login. coba lagi dalam {$minutes} menit."
            ])->withInput($request->only('identity'));
        }

        $fieldType = filter_var($request->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($fieldType, $request->identity)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 300);

            $remaining = RateLimiter::remaining($throttleKey, maxAttempts: 5);

            return back()->withErrors([
                'identity' => "Kredensial yang anda masukkan tidak cocok. Sisa percobaan: {$remaining}x"
            ])->withInput($request->only('identity'));
        }

        if($user->isPending()) {
            return back()->withErrors([
                'identity'  =>  'Akun anda sedang menunggu persetujuan dari Owner.'
            ])->withInput($request->only('identity'));
        }

        if($user->isRejected()) {
            return back()->withErrors([
                'identity'  =>  'Akun anda ditolak. Silahkan hubungi Owner untuk informasi lebih lanjut.'
            ])->withInput($request->only('identity'));
        }

        Auth::login($user, $request->boolean('remember'));
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->route('administrator.dashboard');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:10', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'  =>  User::ROLE_ADMIN,
            'status'    =>  User::STATUS_PENDING  
        ]);

        return redirect()->route('login')
            ->with('info', 'Registrasi Berhasil. Akun anda sedang menunggu persetujuan dari Owner.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/administrator/');
    }
}
