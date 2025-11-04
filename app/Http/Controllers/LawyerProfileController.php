<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\Specialization;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LawyerProfileController extends Controller
{
    public function show()
    {
        $lawyer = Auth::user()->lawyer;
        $lawyer->load(['specializations', 'educations', 'experiences', 'reviews.user']);

        return view('dashboard.lawyers.show', compact('lawyer'));
    }

    public function edit()
    {
        $lawyer = Auth::user()->lawyer;
        $lawyer->load(['specializations', 'educations', 'experiences']);
        $specializations = Specialization::where('is_active', true)->get();

        return view('dashboard.lawyers.edit', compact('lawyer', 'specializations'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        $request->validate([
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Lawyer fields
            'bar_number' => ['required', 'string', 'max:255', Rule::unique('lawyers')->ignore($lawyer->id)],
            'license_state' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'firm_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'services' => ['nullable', 'string'],
            'awards' => ['nullable', 'string'],
            'specializations' => ['nullable', 'array'],
            'specializations.*' => ['exists:specializations,id'],
        ]);

        // Initialize user data array
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $lawyerName = Str::slug($request->name);
            $fileName = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $filePath = $lawyerName . '/' . $fileName;

            // Store in custom "website" disk
            Storage::disk('website')->put($filePath, file_get_contents($request->file('profile_image')));

            $userData['profile_image'] = $filePath;
        }

        // Update User
        $user->update($userData);

        // Update Lawyer
        $lawyer->update([
            'bar_number' => $request->bar_number,
            'license_state' => $request->license_state,
            'bio' => $request->bio,
            'years_of_experience' => $request->years_of_experience,
            'firm_name' => $request->firm_name,
            'website' => $request->website,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'hourly_rate' => $request->hourly_rate,
            'services' => $request->services,
            'awards' => $request->awards,
        ]);

        // Sync specializations
        if ($request->has('specializations')) {
            $syncData = [];
            foreach ($request->specializations as $specId) {
                $syncData[$specId] = [
                    'years_of_experience' => $request->input("specialization_experience.$specId", 0),
                ];
            }
            $lawyer->specializations()->sync($syncData);
        } else {
            $lawyer->specializations()->detach();
        }

        return redirect()->route('lawyer.profile.show')
            ->with('success', 'Profile updated successfully!');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('lawyer.profile.show')
            ->with('success', 'Password updated successfully!');
    }
}
