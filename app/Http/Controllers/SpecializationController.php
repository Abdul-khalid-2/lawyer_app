<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SpecializationController extends Controller
{
    public function index(Request $request)
    {
        $specializations = Specialization::withCount('lawyers')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.specializations.index', compact('specializations'));
    }

    public function create()
    {
        return view('dashboard.specializations.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        Specialization::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('specializations.index')
            ->with('success', 'Specialization created successfully.');
    }

    public function edit(Specialization $specialization)
    {
        return view('dashboard.specializations.edit', compact('specialization'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $validated = $this->validateData($request, $specialization->id);

        $specialization->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('specializations.index')
            ->with('success', 'Specialization updated successfully.');
    }

    public function destroy(Specialization $specialization)
    {
        if ($specialization->lawyers()->count() > 0) {
            return back()->with('error', 'Cannot delete a specialization that is assigned to lawyers.');
        }

        $specialization->delete();

        return redirect()->route('specializations.index')
            ->with('success', 'Specialization deleted successfully.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('specializations', 'name')->ignore($ignoreId)],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);
    }
}
