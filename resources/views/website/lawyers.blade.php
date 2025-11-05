@extends('website.layout.master')

@push('css')
<link rel="stylesheet" href="{{ asset('website/css/browse_lawyers.css') }}">
<style>
    .lawyer-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .lawyer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .rating-stars {
        color: #ffc107;
    }
    .specialization-badge {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="mb-4">Find a Lawyer</h1>
            <p class="text-muted">Browse verified legal professionals near you</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <input type="text" id="locationFilter" class="form-control"
                placeholder="City or State (e.g. New York, CA)"
                value="{{ request('location') }}">
        </div>
        <div class="col-md-4 mb-3">
            <select id="specializationFilter" class="form-select">
                <option value="">All Specializations</option>
                @foreach($specializations as $spec)
                <option value="{{ $spec->uuid }}"
                    {{ request('specialization') == $spec->uuid ? 'selected' : '' }}>
                    {{ $spec->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <button id="applyFilters" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </div>

    <!-- Lawyers Grid -->
    <div id="lawyersContainer" class="row">
        @include('website.lawyers_card', ['lawyers' => $lawyers])
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="text-center my-4 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- No more lawyers message -->
    <div id="noMoreMessage" class="text-center text-muted d-none mt-4">
        <p>No more lawyers found.</p>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let skip = 10;
        let isLoading = false;
        let hasMore = {{ $lawyers->count() >= 10 ? 'true' : 'false' }};
        let currentSpecialization = '{{ request('specialization') }}';
        let currentLocation = '{{ request('location') }}';

        // Apply filters
        document.getElementById('applyFilters').addEventListener('click', function () {
            currentSpecialization = document.getElementById('specializationFilter').value;
            currentLocation = document.getElementById('locationFilter').value;
            resetAndLoad();
        });

        // Allow Enter key to apply filters
        document.getElementById('locationFilter').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('applyFilters').click();
            }
        });

        function resetAndLoad() {
            skip = 0;
            hasMore = true;
            isLoading = false;
            document.getElementById('lawyersContainer').innerHTML = '';
            document.getElementById('noMoreMessage').classList.add('d-none');
            loadLawyers(0);
        }

        function loadLawyers(currentSkip = skip) {
            if (isLoading || !hasMore) return;

            isLoading = true;
            const spinner = document.getElementById('loadingSpinner');
            spinner.classList.remove('d-none');

            fetch("{{ route('website.lawyers.load-more') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    skip: currentSkip,
                    specialization: currentSpecialization,
                    location: currentLocation
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.html) {
                    document.getElementById('lawyersContainer').insertAdjacentHTML('beforeend', data.html);
                }
                hasMore = data.hasMore;
                skip = data.nextSkip;

                if (!hasMore && currentSkip === 0) {
                    // No lawyers found on initial filter
                    document.getElementById('lawyersContainer').innerHTML = 
                        '<div class="col-12 text-center"><p class="text-muted">No lawyers found matching your criteria.</p></div>';
                } else if (!hasMore && currentSkip > 0) {
                    // No more lawyers to load
                    document.getElementById('noMoreMessage').classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error loading lawyers:', error);
                hasMore = false;
                if (currentSkip === 0) {
                    document.getElementById('lawyersContainer').innerHTML = 
                        '<div class="col-12 text-center"><p class="text-danger">Error loading lawyers. Please try again.</p></div>';
                }
            })
            .finally(() => {
                isLoading = false;
                spinner.classList.add('d-none');
            });
        }

        // Infinite scroll
        window.addEventListener('scroll', () => {
            if (!hasMore || isLoading) return;

            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 300) {
                loadLawyers();
            }
        });
    });
</script>
@endpush