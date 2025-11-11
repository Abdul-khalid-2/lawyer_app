<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('home');
        // return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $redirectUrl = $this->getRedirectUrl();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => $redirectUrl
            ]);
        }

        return redirect()->intended($redirectUrl);
    }

    /**
     * Get redirect URL based on user role.
     */
    protected function getRedirectUrl(): string
    {
        $user = Auth::user();
        
        if (in_array($user->role, ['super_admin', 'lawyer'])) {
            return route('dashboard');
        }

        return route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse|RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
                'redirect' => url('/')
            ]);
        }

        return redirect('/');
    }
}
