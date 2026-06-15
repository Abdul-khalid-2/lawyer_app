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

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
        ];

        if ($request->hasFile('profile_image')) {
            $lawyerName = Str::slug($validated['name']);
            $fileName = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $filePath = $lawyerName . '/' . $fileName;

            Storage::disk('website')->put($filePath, file_get_contents($request->file('profile_image')));

            $userData['profile_image'] = $filePath;
        }

        $user->update($userData);

        return redirect()
            ->route('lawyer.profile.edit')
            ->with('success', 'Personal information updated successfully.')
            ->with('active_tab', 'personal');
    }

    public function updateProfessional(Request $request)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        $validated = $request->validate([
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

        $lawyer->update([
            'bar_number' => $validated['bar_number'],
            'license_state' => $validated['license_state'],
            'bio' => $validated['bio'] ?? null,
            'years_of_experience' => $validated['years_of_experience'],
            'firm_name' => $validated['firm_name'] ?? null,
            'website' => $validated['website'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'country' => $validated['country'] ?? null,
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'services' => $validated['services'] ?? null,
            'awards' => $validated['awards'] ?? null,
        ]);

        if ($request->has('specializations')) {
            $syncData = [];
            foreach ($request->specializations as $specId) {
                $syncData[$specId] = [
                    'years_of_experience' => $request->input("specialization_experience.{$specId}", 0) ?: 0,
                ];
            }
            $lawyer->specializations()->sync($syncData);
        } else {
            $lawyer->specializations()->detach();
        }

        return redirect()
            ->route('lawyer.profile.edit')
            ->with('success', 'Professional information updated successfully.')
            ->with('active_tab', 'professional');
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

        return redirect()
            ->route('lawyer.profile.edit')
            ->with('success', 'Password updated successfully.')
            ->with('active_tab', 'password');
    }
}
