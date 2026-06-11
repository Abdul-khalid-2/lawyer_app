<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseRequest;
use App\Models\CaseDocument;
use App\Models\CaseHearing;
use App\Models\CaseNote;
use App\Models\Client;
use App\Models\LegalCase;
use App\Models\Schedule;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $cases = LegalCase::with(['client.user', 'teamMember'])
            ->where('lawyer_id', $lawyer->id)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('client_id'), fn ($q) => $q->where('client_id', $request->client_id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($sq) use ($search) {
                    $sq->where('title', 'like', "%{$search}%")
                        ->orWhere('case_number', 'like', "%{$search}%")
                        ->orWhere('court_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $clients = Client::with('user')->where('lawyer_id', $lawyer->id)->get();

        return view('dashboard.cases.index', compact('cases', 'clients'));
    }

    public function create()
    {
        $lawyer = Auth::user()->lawyer;
        $clients = Client::with('user')->where('lawyer_id', $lawyer->id)->active()->get();
        $teamMembers = TeamMember::where('lawyer_id', $lawyer->id)->active()->ordered()->get();

        return view('dashboard.cases.create', compact('clients', 'teamMembers'));
    }

    public function store(CaseRequest $request)
    {
        $lawyer = Auth::user()->lawyer;
        $validated = $request->validated();

        $validated['lawyer_id'] = $lawyer->id;
        $validated['is_visible_to_client'] = $request->boolean('is_visible_to_client', true);

        $case = LegalCase::create($validated);

        return redirect()->route('cases.show', $case)
            ->with('success', 'Case created successfully!');
    }

    public function show(LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $case->load([
            'client.user',
            'teamMember',
            'documents.uploader',
            'notes.user',
            'hearings' => fn ($q) => $q->orderBy('hearing_date', 'desc'),
        ]);

        return view('dashboard.cases.show', compact('case'));
    }

    public function edit(LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $lawyer = Auth::user()->lawyer;
        $clients = Client::with('user')->where('lawyer_id', $lawyer->id)->get();
        $teamMembers = TeamMember::where('lawyer_id', $lawyer->id)->ordered()->get();

        return view('dashboard.cases.edit', compact('case', 'clients', 'teamMembers'));
    }

    public function update(CaseRequest $request, LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $validated = $request->validated();
        $validated['is_visible_to_client'] = $request->boolean('is_visible_to_client');

        $case->update($validated);

        return redirect()->route('cases.show', $case)
            ->with('success', 'Case updated successfully!');
    }

    public function destroy(LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', 'Case deleted successfully!');
    }

    public function updateStatus(Request $request, LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $request->validate([
            'status' => ['required', Rule::in(LegalCase::STATUSES)],
        ]);

        $case->update(['status' => $request->status]);

        return back()->with('success', 'Case status updated to ' . str_replace('_', ' ', $request->status) . '.');
    }

    // ----- Documents -----

    public function storeDocument(Request $request, LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $request->validate([
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $path = $file->store('cases/' . $case->uuid, 'public');

        CaseDocument::create([
            'case_id' => $case->id,
            'uploaded_by' => Auth::id(),
            'title' => $request->title,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'is_visible_to_client' => $request->boolean('is_visible_to_client'),
        ]);

        return back()->with('success', 'Document uploaded successfully!');
    }

    public function toggleDocumentVisibility(LegalCase $case, CaseDocument $document)
    {
        $this->authorizeOwnership($case);
        abort_unless($document->case_id === $case->id, 404);

        $document->update(['is_visible_to_client' => !$document->is_visible_to_client]);

        return back()->with('success', 'Document visibility updated.');
    }

    public function destroyDocument(LegalCase $case, CaseDocument $document)
    {
        $this->authorizeOwnership($case);
        abort_unless($document->case_id === $case->id, 404);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }

    // ----- Notes -----

    public function storeNote(Request $request, LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $request->validate([
            'note' => 'required|string',
        ]);

        CaseNote::create([
            'case_id' => $case->id,
            'user_id' => Auth::id(),
            'note' => $request->note,
            'is_private' => $request->boolean('is_private'),
        ]);

        return back()->with('success', 'Note added.');
    }

    public function destroyNote(LegalCase $case, CaseNote $note)
    {
        $this->authorizeOwnership($case);
        abort_unless($note->case_id === $case->id, 404);

        $note->delete();

        return back()->with('success', 'Note deleted.');
    }

    // ----- Hearings -----

    public function storeHearing(Request $request, LegalCase $case)
    {
        $this->authorizeOwnership($case);

        $validated = $request->validate([
            'hearing_date' => 'required|date',
            'hearing_time' => 'nullable|date_format:H:i',
            'court_name' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:100',
            'purpose' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $case) {
            CaseHearing::create([
                'case_id' => $case->id,
                'hearing_date' => $validated['hearing_date'],
                'hearing_time' => $validated['hearing_time'] ?? null,
                'court_name' => $validated['court_name'] ?? $case->court_name,
                'room' => $validated['room'] ?? null,
                'purpose' => $validated['purpose'] ?? null,
                'status' => 'scheduled',
            ]);

            $start = \Carbon\Carbon::parse($validated['hearing_date'] . ' ' . ($validated['hearing_time'] ?? '09:00'));

            Schedule::create([
                'lawyer_id' => $case->lawyer_id,
                'title' => 'Hearing: ' . $case->title,
                'type' => 'hearing',
                'start_datetime' => $start,
                'end_datetime' => $start->copy()->addHour(),
                'location' => $validated['court_name'] ?? $case->court_name,
                'case_id' => $case->id,
                'is_public' => false,
            ]);

            // Keep the case's next hearing date in sync
            $nextHearing = $case->hearings()->upcoming()->first();
            $case->update(['next_hearing_date' => $nextHearing?->hearing_date]);
        });

        return back()->with('success', 'Hearing scheduled — it has been added to your calendar.');
    }

    public function updateHearing(Request $request, LegalCase $case, CaseHearing $hearing)
    {
        $this->authorizeOwnership($case);
        abort_unless($hearing->case_id === $case->id, 404);

        $validated = $request->validate([
            'outcome' => 'nullable|string',
            'status' => ['required', Rule::in(CaseHearing::STATUSES)],
        ]);

        $hearing->update($validated);

        $nextHearing = $case->hearings()->upcoming()->first();
        $case->update(['next_hearing_date' => $nextHearing?->hearing_date]);

        return back()->with('success', 'Hearing updated.');
    }

    // ----- Helpers -----

    private function authorizeOwnership(LegalCase $case): void
    {
        \Illuminate\Support\Facades\Gate::authorize('manage', $case);
    }
}
