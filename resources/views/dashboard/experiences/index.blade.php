<x-app-layout>

    <section id="experiences" class="page-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Professional Experience</h2>
                <p class="text-muted">Manage your work experience and employment history</p>
            </div>
            <a href="{{ route('experiences.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Experience
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($experiences->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($experiences as $experience)
                            <tr>
                                <td>
                                    <strong>{{ $experience->position }}</strong>
                                </td>
                                <td>{{ $experience->company }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $experience->formatted_date }}<br>
                                        <span class="badge bg-light text-dark">{{ $experience->duration }}</span>
                                    </small>
                                </td>
                                <td>
                                    @if($experience->is_current)
                                    <span class="badge bg-success">Current</span>
                                    @else
                                    <span class="badge bg-secondary">Past</span>
                                    @endif
                                </td>
                                <td>
                                    @if($experience->description)
                                    {{ Str::limit($experience->description, 50) }}
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('experiences.edit', $experience->id) }}" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('experiences.destroy', $experience->id) }}" 
                                                method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Delete this experience record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Experience Added</h5>
                    <p class="text-muted mb-4">Add your professional experience to showcase your career journey.</p>
                    <a href="{{ route('experiences.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add Your First Experience
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Experience Timeline View (Alternative Display) -->
        @if($experiences->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Experience Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($experiences as $experience)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $experience->position }}</h6>
                                    <p class="mb-1 text-muted">{{ $experience->company }}</p>
                                    <small class="text-muted">
                                        {{ $experience->formatted_date }} • {{ $experience->duration }}
                                        @if($experience->is_current)
                                        <span class="badge bg-success ms-2">Current</span>
                                        @endif
                                    </small>
                                    @if($experience->description)
                                    <p class="mt-2 mb-0">{{ $experience->description }}</p>
                                    @endif
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('experiences.edit', $experience->id) }}" 
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </section>


    <style>
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }
        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--bs-primary);
        }
        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid var(--bs-primary);
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -1.94rem;
            top: 1.5rem;
            bottom: -1rem;
            width: 2px;
            background: #dee2e6;
        }
    </style>
</x-app-layout>