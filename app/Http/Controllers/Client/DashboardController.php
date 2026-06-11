<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CaseHearing;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;

        abort_unless($client, 403, 'No client profile found for your account.');

        $lawyer = $client->lawyer()->with('user')->first();

        $visibleCases = $client->cases()->visibleToClient()->get();

        $caseStats = [
            'total' => $visibleCases->count(),
            'active' => $visibleCases->whereIn('status', ['pending', 'active'])->count(),
            'closed' => $visibleCases->whereIn('status', ['won', 'lost', 'closed'])->count(),
        ];

        $nextHearing = CaseHearing::whereIn('case_id', $visibleCases->pluck('id'))
            ->upcoming()
            ->with('legalCase')
            ->first();

        $recentCases = $client->cases()->visibleToClient()->latest()->take(5)->get();

        return view('client.dashboard', compact('client', 'lawyer', 'caseStats', 'nextHearing', 'recentCases'));
    }
}
