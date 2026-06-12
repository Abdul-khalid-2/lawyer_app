<x-website.layout.master title="Find a Lawyer - Browse Verified Legal Professionals | Law-Skoolyst"
    description="Browse and connect with verified lawyers and legal professionals near you. Filter by specialization, experience and location.">

<x-website.sections.page-hero icon="fas fa-balance-scale"
    title="Find the Right Lawyer"
    subtitle="Browse verified legal professionals by specialization, experience and location." />

<div class="container py-5">
    <!-- Filters -->
    <div class="row mb-5 align-items-end">
        <div class="col-md-4">
            <x-website.ui.input name="location" id="locationFilter" icon="fas fa-map-marker-alt"
                :value="request('location')" placeholder="City or State (e.g. New York, CA)" />
        </div>
        <div class="col-md-4">
            <x-website.ui.select name="specialization" id="specializationFilter" icon="fas fa-gavel">
                <option value="">All Specializations</option>
                @foreach($specializations as $spec)
                <option value="{{ $spec->uuid }}"
                    {{ request('specialization') == $spec->uuid ? 'selected' : '' }}>
                    {{ $spec->name }}
                </option>
                @endforeach
            </x-website.ui.select>
        </div>
        <div class="col-md-4 mb-3">
            <x-website.ui.button id="applyFilters" variant="primary" icon="fas fa-filter" class="w-100">Apply Filters</x-website.ui.button>
        </div>
    </div>

    <!-- Lawyers Grid -->
    <div id="lawyersContainer" class="row" data-load-more-url="{{ route('website.lawyers.load-more') }}">
        @include('website.partials.lawyer-grid', ['lawyers' => $lawyers])
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
</x-website.layout.master>
