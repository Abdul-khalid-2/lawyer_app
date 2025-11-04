<x-app-layout>

    <section id="educations" class="page-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Education</h2>
                <p class="text-muted">Manage your educational background</p>
            </div>
            <a href="{{ route('educations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Education
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($educations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Degree</th>
                                <th>Institution</th>
                                <th>Year</th>
                                <th>Description</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($educations as $education)
                            <tr>
                                <td>
                                    <strong>{{ $education->degree }}</strong>
                                </td>
                                <td>{{ $education->institution }}</td>
                                <td>{{ $education->graduation_year }}</td>
                                <td>
                                    @if($education->description)
                                    {{ Str::limit($education->description, 50) }}
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $education->order }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('educations.edit', $education->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('educations.destroy', $education->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this education record?')">
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
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Education Added</h5>
                    <p class="text-muted mb-4">Add your educational background to showcase your qualifications.</p>
                    <a href="{{ route('educations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add Your First Education
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>