<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'bar_number' => ['required', 'string', 'max:255', 'unique:lawyers'],
            'license_state' => ['required', 'string', 'max:255'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'bio' => ['nullable', 'string'],
            'firm_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role' => 'lawyer', // Set role as lawyer
            'password' => Hash::make($request->password),
        ]);

        // Create Lawyer Profile
        $lawyer = Lawyer::create([
            'user_id' => $user->id,
            'uuid' => \Illuminate\Support\Str::uuid(),
            'bar_number' => $request->bar_number,
            'license_state' => $request->license_state,
            'bio' => $request->bio,
            'years_of_experience' => $request->years_of_experience,
            'firm_name' => $request->firm_name,
            'is_verified' => false, // Default to unverified, admin can verify later
            'is_active' => true,
        ]);

        // Assign Lawyer Role
        $user->assignRole('lawyer');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
