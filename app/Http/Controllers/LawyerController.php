<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\Specialization;
use Illuminate\Http\Request;

class LawyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lawyer::with(['user', 'specializations']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by specialization
        if ($request->has('specialization') && $request->specialization) {
            $query->whereHas('specializations', function ($q) use ($request) {
                $q->where('specializations.id', $request->specialization);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'experience':
                $query->orderBy('years_of_experience', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->join('users', 'lawyers.user_id', '=', 'users.id')
                    ->orderBy('users.name');
        }

        $lawyers = $query->paginate(10);
        $specializations = Specialization::where('is_active', true)->get();

        return view('dashboard.lawyers.index', compact('lawyers', 'specializations'));
    }

    public function create()
    {
        $specializations = Specialization::where('is_active', true)->get();
        return view('lawyers.create', compact('specializations'));
    }

    public function store(Request $request)
    {
        // Implementation for storing lawyer
    }

    public function show(Lawyer $lawyer)
    {
        $lawyer->load(['user', 'specializations', 'educations', 'experiences', 'reviews.user']);
        return view('lawyers.show', compact('lawyer'));
    }

    public function edit(Lawyer $lawyer)
    {
        $specializations = Specialization::where('is_active', true)->get();
        $lawyer->load('specializations');
        return view('lawyers.edit', compact('lawyer', 'specializations'));
    }

    public function update(Request $request, Lawyer $lawyer)
    {
        // Implementation for updating lawyer
    }

    public function destroy(Lawyer $lawyer)
    {
        // Implementation for deleting lawyer
    }
}
