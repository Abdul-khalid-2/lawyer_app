<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $educations = $lawyer->educations()->orderBy('order')->get();

        return view('dashboard.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('dashboard.educations.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $lawyer = Auth::user()->lawyer;

        Education::create([
            'uuid' => Str::uuid(),
            'lawyer_id' => $lawyer->id,
            'degree' => $validated['degree'],
            'institution' => $validated['institution'],
            'graduation_year' => $validated['graduation_year'],
            'description' => $validated['description'],
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('educations.index')
            ->with('success', 'Education added successfully.');
    }

    public function show(Education $education)
    {
        // Verify the education belongs to the authenticated lawyer
        // $this->authorize('view', $education);

        return view('dashboard.educations.show', compact('education'));
    }

    public function edit(Education $education)
    {
        // $this->authorize('update', $education);

        return view('dashboard.educations.form', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        // $this->authorize('update', $education);

        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $education->update($validated);

        return redirect()->route('educations.index')
            ->with('success', 'Education updated successfully.');
    }

    public function destroy(Education $education)
    {
        // $this->authorize('delete', $education);

        $education->delete();

        return redirect()->route('educations.index')
            ->with('success', 'Education deleted successfully.');
    }
}
