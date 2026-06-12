<x-website.layout.master
    :title="$lawyer->user->name . ' — Lawyer Profile | Law-Skoolyst'"
    :description="$lawyer->bio ? \Illuminate\Support\Str::limit(strip_tags($lawyer->bio), 155) : 'View the profile, experience, qualifications and reviews of ' . $lawyer->user->name . ' on Law-Skoolyst.'"
    data-track-url="{{ route('website.track-time', $lawyer->uuid) }}">

    <!-- Profile Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @include('website.partials.profile._header')
                @include('website.partials.profile._about')
                @include('website.partials.profile._specializations')
                @include('website.partials.profile._experience')
                @include('website.partials.profile._education')
                @include('website.partials.profile._portfolio')
                @include('website.partials.profile._team')
                @include('website.partials.profile._availability')
                @include('website.partials.profile._reviews')
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                @include('website.partials.profile._sidebar')
            </div>
        </div>
    </div>

    @include('website.partials.profile._schedule_modal')
</x-website.layout.master>
