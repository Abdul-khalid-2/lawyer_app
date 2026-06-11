<x-app-layout>
    <div class="container-fluid">
        <h1 class="h3 mb-4">My Cases</h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Case No.</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Court</th>
                                <th>Next Hearing</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cases as $case)
                            <tr>
                                <td>{{ $case->case_number ?? '—' }}</td>
                                <td>{{ Str::limit($case->title, 45) }}</td>
                                <td>{{ ucfirst($case->type) }}</td>
                                <td>{{ $case->court_name ?? '—' }}</td>
                                <td>
                                    @if($case->next_hearing_date)
                                    <span class="text-danger fw-bold">{{ $case->next_hearing_date->format('d M Y') }}</span>
                                    @else
                                    —
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $case->status_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('client.cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-briefcase fa-3x text-muted mb-3 d-block"></i>
                                    You have no cases yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $cases->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
