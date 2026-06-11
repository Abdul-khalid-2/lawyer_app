<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $teamMembers = TeamMember::where('lawyer_id', $lawyer->id)
            ->ordered()
            ->paginate(12);

        return view('dashboard.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('dashboard.team.create');
    }

    public function store(TeamMemberRequest $request)
    {
        $validated = $request->validated();
        $lawyer = Auth::user()->lawyer;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        $validated['lawyer_id'] = $lawyer->id;
        $validated['is_active'] = $request->boolean('is_active');

        TeamMember::create($validated);

        return redirect()->route('team-members.index')
            ->with('success', 'Team member added successfully!');
    }

    public function edit(TeamMember $teamMember)
    {
        $this->authorizeOwnership($teamMember);

        return view('dashboard.team.edit', compact('teamMember'));
    }

    public function update(TeamMemberRequest $request, TeamMember $teamMember)
    {
        $this->authorizeOwnership($teamMember);

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($teamMember->photo) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $teamMember->update($validated);

        return redirect()->route('team-members.index')
            ->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $teamMember)
    {
        $this->authorizeOwnership($teamMember);

        $teamMember->delete();

        return redirect()->route('team-members.index')
            ->with('success', 'Team member removed successfully!');
    }

    private function authorizeOwnership(TeamMember $teamMember): void
    {
        \Illuminate\Support\Facades\Gate::authorize('manage', $teamMember);
    }
}
