<!-- Portfolio/Cases Section -->
@if($lawyer->portfolios->count() > 0)
<div class="profile-section">
    <h3 class="section-title">Notable Cases</h3>
    @foreach($lawyer->portfolios as $portfolio)
    <div class="card mb-3">
        <div class="card-body">
            @if($portfolio->is_featured)
            <span class="badge bg-warning mb-2">Featured Case</span>
            @endif
            <h5 class="card-title">{{ $portfolio->title }}</h5>
            @if($portfolio->case_type)
            <span class="badge bg-primary mb-2">{{ $portfolio->case_type }}</span>
            @endif
            @if($portfolio->year)
            <span class="badge bg-secondary mb-2">{{ $portfolio->year }}</span>
            @endif

            @if($portfolio->description)
            <p class="card-text">{{ Str::limit($portfolio->description, 200) }}</p>
            @endif

            @if($portfolio->outcome)
            <p class="mb-1"><strong>Outcome:</strong>
                <span class="badge {{ \Illuminate\Support\Str::contains(strtolower($portfolio->outcome), ['won', 'success', 'favor']) ? 'bg-success' : 'bg-info' }}">
                    {{ $portfolio->outcome }}
                </span>
            </p>
            @endif

            @if($portfolio->case_value)
            <p class="mb-1"><strong>Case Value:</strong> ${{ number_format($portfolio->case_value) }}</p>
            @endif

            @if($portfolio->client_name)
            <p class="mb-0 text-muted"><small>Client: {{ $portfolio->client_name }}</small></p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif
