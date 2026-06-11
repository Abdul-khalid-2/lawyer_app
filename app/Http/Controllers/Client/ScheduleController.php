<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CaseHearing;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        abort_unless($client, 403);

        $lawyer = $client->lawyer()->with('user')->first();

        // Lawyer's public availability — no case details
        $publicSlots = Schedule::where('lawyer_id', $client->lawyer_id)
            ->public()
            ->upcoming()
            ->take(10)
            ->get();

        // Hearings of the client's own visible cases
        $visibleCaseIds = $client->cases()->visibleToClient()->pluck('id');
        $hearings = CaseHearing::whereIn('case_id', $visibleCaseIds)
            ->with('legalCase')
            ->orderBy('hearing_date', 'desc')
            ->get();

        return view('client.schedule', compact('lawyer', 'publicSlots', 'hearings'));
    }
}
