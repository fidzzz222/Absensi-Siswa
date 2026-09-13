<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->redirectByRole($user)->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau Password yang Anda masukkan salah!');
    }

    public function redirectByRole($userOrRole)
    {
        $role = is_object($userOrRole) ? ($userOrRole->role ?? null) : $userOrRole;

        switch ($role) {
            case 'siswa':
                return redirect()->route('dashboard.siswa');
            case 'guru_mapel':
                return redirect()->route('dashboard.guru');
            case 'sekretaris':
                return redirect()->route('dashboard.sekretaris');
            case 'guru_bk':
                return redirect()->route('dashboard.guru_bk');
            case 'guru_piket':
                return redirect()->route('dashboard.guru_piket');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar (logout).');
    }
}
