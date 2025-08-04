<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.refactorLogin');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redireccionar según el rol
            if ($user->role === 'Admin') {
                return redirect()->route('ventas.index');
            } elseif ($user->role === 'Vendedor') {
                return redirect()->route('ventas.index');
            } elseif ($user->role === 'Almacenista') {
                return redirect()->route('categories.index');
            } else {
                return redirect()->route('ventas.index');
            }
        }

        return back()
            ->withErrors(['email' => 'Credenciales inválidas'])
            ->withInput($request->only('email'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
