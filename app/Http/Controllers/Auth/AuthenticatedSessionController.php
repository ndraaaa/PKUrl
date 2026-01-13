<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if ($user) {

            // 1️⃣ Password sudah ter-hash
            if (
                $this->looksHashed($user->password)
                && Hash::check($credentials['password'], $user->password)
            ) {

                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard', absolute: false));
            }

            // 2️⃣ Password legacy (plaintext)
            if (
                !$this->looksHashed($user->password)
                && $user->password === $credentials['password']
            ) {

                // Re-hash password
                $user->password = Hash::make($credentials['password']);
                $user->save();

                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard', absolute: false));
            }
        }

        return back()->withErrors([
            'username' => __('auth.failed'),
        ])->onlyInput('username');
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

    /**
     * Heuristic check untuk hash bcrypt / argon
     */
    private function looksHashed(?string $value): bool
    {
        if (!$value) {
            return false;
        }

        return preg_match('/^\$(2y|2a|argon2id|argon2i)\$/', $value) === 1;
    }
}
