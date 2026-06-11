<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $cases = $lawyer->cases()->with('client.user')->get();

        return view('dashboard.schedule.index', compact('cases'));
    }

    public function getEvents(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $query = Schedule::where('lawyer_id', $lawyer->id);

        if ($request->filled('start')) {
            $query->where('end_datetime', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->where('start_datetime', '<=', $request->end);
        }

        $events = $query->get()->map(function (Schedule $schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->title,
                'start' => $schedule->start_datetime->toIso8601String(),
                'end' => $schedule->end_datetime->toIso8601String(),
                'color' => $schedule->color,
                'extendedProps' => [
                    'type' => $schedule->type,
                    'location' => $schedule->location,
                    'case_id' => $schedule->case_id,
                    'is_public' => $schedule->is_public,
                    // hearing schedules are managed from the case page
                    'editable' => $schedule->type !== 'hearing',
                ],
            ];
        });

        return response()->json($events);
    }

    public function store(ScheduleRequest $request)
    {
        $lawyer = Auth::user()->lawyer;
        $validated = $request->validated();

        $validated['lawyer_id'] = $lawyer->id;
        $validated['is_public'] = $request->boolean('is_public');

        $schedule = Schedule::create($validated);

        return response()->json(['success' => true, 'id' => $schedule->id]);
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->authorizeOwnership($schedule);

        $validated = $request->validated();
        $validated['is_public'] = $request->boolean('is_public');

        $schedule->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorizeOwnership($schedule);

        $schedule->delete();

        return response()->json(['success' => true]);
    }

    private function authorizeOwnership(Schedule $schedule): void
    {
        if ($schedule->lawyer_id !== Auth::user()->lawyer?->id) {
            abort(403);
        }
    }
}
