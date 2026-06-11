<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LegalCase;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        abort_unless($client, 403);

        $cases = $client->cases()
            ->visibleToClient()
            ->with('teamMember')
            ->latest()
            ->paginate(10);

        return view('client.cases.index', compact('cases'));
    }

    public function show(LegalCase $case)
    {
        $client = Auth::user()->client;
        abort_unless($client, 403);

        \Illuminate\Support\Facades\Gate::authorize('view', $case);

        $case->load([
            'lawyer.user',
            'teamMember',
            'hearings' => fn ($q) => $q->orderBy('hearing_date', 'desc'),
        ]);

        // Only client-visible material — private notes and hidden documents never leave the server
        $documents = $case->documents()->visibleToClient()->with('uploader')->get();
        $notes = $case->notes()->visibleToClient()->with('user')->latest()->get();

        return view('client.cases.show', compact('case', 'documents', 'notes'));
    }
}
