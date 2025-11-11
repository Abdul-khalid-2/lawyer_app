<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Specialization;
use App\Models\User;
use Exception;
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
        $specializations = Specialization::all();
        return view('auth.register', compact('specializations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Determine if user is registering as lawyer or client
        if ($request->user_type === 'lawyer') {
            return $this->registerLawyer($request);
        }

        // Client registration
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'], // Changed from 'name'
            'last_name' => ['required', 'string', 'max:255'],  // Added last_name
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'terms' => ['accepted'], // Added terms validation
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name, // Combine first and last name
            'email' => $request->email,
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        // Assign client role if using Spatie permissions
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('client');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }

    /**
     * Handle lawyer registration
     */
    protected function registerLawyer(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization_id' => ['required', 'exists:specializations,id'], // Changed from 'specialization'
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ]);

        try {
            // Create User
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'role' => 'lawyer',
                'password' => $request->password,
            ]);

            // Create Lawyer linked to User
            $lawyer = Lawyer::create([
                'user_id' => $user->id,
                'uuid' => \Illuminate\Support\Str::uuid(),
            ]);

            $user->assignRole('lawyer');

            // Attach specialization using specialization_id
            $lawyer->specializations()->attach($request->specialization_id);

            event(new Registered($user));

            // Log in the lawyer
            Auth::guard('web')->login($user);

            return redirect()->route('lawyer.dashboard');
        } catch (Exception $e) {
            // Log the error for debugging
            return redirect()->route('register')
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }
}
