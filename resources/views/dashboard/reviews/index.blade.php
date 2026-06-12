<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Client Reviews" subtitle="Approve, reject and feature the reviews clients leave on your profile" icon="fas fa-star" />

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <!-- Stat tiles -->
        <div class="row mb-2">
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Total Reviews" :value="$counts['all']" icon="fas fa-comments" variant="primary" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Pending" :value="$counts['pending']" icon="fas fa-clock" variant="warning" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Approved" :value="$counts['approved']" icon="fas fa-check-circle" variant="success" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Avg Rating" :value="number_format($avgRating, 1) . '/5'" icon="fas fa-star" variant="info" />
            </div>
        </div>

        <!-- Status filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="btn-group" role="group">
                    @php $current = request('status'); @endphp
                    <a href="{{ route('lawyer.reviews.index') }}" class="btn btn-{{ $current ? 'outline-primary' : 'primary' }}">All ({{ $counts['all'] }})</a>
                    <a href="{{ route('lawyer.reviews.index', ['status' => 'pending']) }}" class="btn btn-{{ $current === 'pending' ? 'warning' : 'outline-warning' }}">Pending ({{ $counts['pending'] }})</a>
                    <a href="{{ route('lawyer.reviews.index', ['status' => 'approved']) }}" class="btn btn-{{ $current === 'approved' ? 'success' : 'outline-success' }}">Approved ({{ $counts['approved'] }})</a>
                    <a href="{{ route('lawyer.reviews.index', ['status' => 'rejected']) }}" class="btn btn-{{ $current === 'rejected' ? 'danger' : 'outline-danger' }}">Rejected ({{ $counts['rejected'] }})</a>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="card">
            <div class="card-body">
                @forelse($reviews as $review)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                        <div>
                            <h6 class="mb-1">
                                {{ $review->user->name ?? 'Anonymous Client' }}
                                @if($review->is_featured)<span class="badge bg-warning text-dark"><i class="fas fa-star"></i> Featured</span>@endif
                            </h6>
                            <div class="text-warning mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                @endfor
                                <span class="text-muted small ms-1">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <span class="badge bg-{{ $review->status_badge ?? ($review->status === 'approved' ? 'success' : ($review->status === 'rejected' ? 'danger' : 'warning')) }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </div>

                    @if($review->title)<p class="fw-semibold mb-1">{{ $review->title }}</p>@endif
                    <p class="mb-3">{{ $review->review }}</p>

                    <div class="d-flex flex-wrap gap-2">
                        @if($review->status !== 'approved')
                        <form action="{{ route('lawyer.reviews.status', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check me-1"></i> Approve</button>
                        </form>
                        @endif

                        @if($review->status !== 'rejected')
                        <form action="{{ route('lawyer.reviews.status', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times me-1"></i> Reject</button>
                        </form>
                        @endif

                        @if($review->status !== 'pending')
                        <form action="{{ route('lawyer.reviews.status', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-undo me-1"></i> Mark Pending</button>
                        </form>
                        @endif

                        <form action="{{ route('lawyer.reviews.feature', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Featured reviews appear first on your public profile">
                                <i class="fas fa-star me-1"></i>{{ $review->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>

                        <form action="{{ route('lawyer.reviews.destroy', $review) }}" method="POST" class="ms-auto">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review permanently?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <x-dashboard.empty-state icon="fas fa-star"
                    title="No reviews{{ request('status') ? ' with this status' : ' yet' }}"
                    message="Reviews left by clients on your public profile will appear here for approval." />
                @endforelse

                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
