<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        /* $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false)); */
        $request->validate([
            'pseudo' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->pseudo, 'password' => $request->password])) {
            return redirect()->intended('/profile');
        }
        return back()->withErrors(['error' => 'Pseudo ou mot de passe incorrect veillez réessayer ou contacter l\'administrateur']);
  
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
