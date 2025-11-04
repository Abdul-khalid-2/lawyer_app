<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExperienceController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $experiences = $lawyer->experiences()->orderBy('start_date', 'desc')->get();

        return view('dashboard.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('dashboard.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $lawyer = Auth::user()->lawyer;

        Experience::create([
            'uuid' => Str::uuid(),
            'lawyer_id' => $lawyer->id,
            'position' => $validated['position'],
            'company' => $validated['company'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['is_current'] ? null : $validated['end_date'],
            'is_current' => $validated['is_current'] ?? false,
            'description' => $validated['description'],
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('experiences.index')
            ->with('success', 'Experience added successfully.');
    }

    public function show(Experience $experience)
    {
        // $this->authorize('view', $experience);

        return view('dashboard.experiences.show', compact('experience'));
    }

    public function edit(Experience $experience)
    {
        // $this->authorize('update', $experience);

        return view('dashboard.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        // $this->authorize('update', $experience);

        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $experience->update([
            'position' => $validated['position'],
            'company' => $validated['company'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['is_current'] ? null : $validated['end_date'],
            'is_current' => $validated['is_current'] ?? false,
            'description' => $validated['description'],
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        // $this->authorize('delete', $experience);

        $experience->delete();

        return redirect()->route('experiences.index')
            ->with('success', 'Experience deleted successfully.');
    }
}
