<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $cases = LegalCase::with(['lawyer.user', 'client.user', 'teamMember'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($sq) use ($search) {
                    $sq->where('title', 'like', "%{$search}%")
                        ->orWhere('case_number', 'like', "%{$search}%")
                        ->orWhere('court_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.admin.cases.index', compact('cases'));
    }

    public function show(LegalCase $case)
    {
        $case->load([
            'lawyer.user',
            'client.user',
            'teamMember',
            'documents.uploader',
            'notes.user',
            'hearings' => fn ($q) => $q->orderBy('hearing_date', 'desc'),
        ]);

        return view('dashboard.admin.cases.show', compact('case'));
    }
}
