<x-app-layout>
    <!-- Dashboard Page -->
    <section id="dashboard" class="page-section active">
        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                                <p class="mb-0 opacity-75">
                                    @if($lawyer->firm_name)
                                        {{ $lawyer->firm_name }}
                                    @else
                                        Your Legal Practice Dashboard
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 d-inline-block">
                                    <i class="fas fa-balance-scale fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title opacity-75">Profile Visitors</h6>
                                <h2 class="mb-0">{{ $stats['total_visitors'] ?? 0 }}</h2>
                                <small class="opacity-75">
                                    {{ $stats['profile_views'] ?? 0 }} total views
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="fas fa-eye fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card text-white"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title opacity-75">Total Reviews</h6>
                                <h2 class="mb-0">{{ $stats['total_reviews'] ?? 0 }}</h2>
                                <small class="opacity-75">
                                    {{ number_format($stats['average_rating'] ?? 0, 1) }} ★ average
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card text-white"
                    style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title opacity-75">Blog Posts</h6>
                                <h2 class="mb-0">{{ $stats['total_blog_posts'] ?? 0 }}</h2>
                                <small class="opacity-75">
                                    {{ $stats['published_posts'] ?? 0 }} published
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="fas fa-blog fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stats-card text-white"
                    style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title opacity-75">Portfolio</h6>
                                <h2 class="mb-0">{{ $stats['portfolios_count'] ?? 0 }}</h2>
                                <small class="opacity-75">
                                    {{ $stats['specializations_count'] ?? 0 }} specializations
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="fas fa-gavel fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title">Profile Visitors Overview</h5>
                        <p class="text-muted small">Visitor trends over the past 30 days</p>
                    </div>
                    <div class="card-body">
                        @if(!empty($visitorChartData))
                        <div class="bg-light rounded p-4">
                            <canvas id="visitorChart" height="250"></canvas>
                        </div>
                        @else
                        <div class="bg-light rounded p-5 text-center">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Visitor Analytics</p>
                            <p class="small text-muted">No visitor data available yet</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card chart-card h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title">Specializations</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($specializationData) && count($specializationData) > 0)
                            @foreach($specializationData as $specialization)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>
                                    @if($specialization['icon'])
                                        <i class="{{ $specialization['icon'] }} me-2 text-primary"></i>
                                    @endif
                                    {{ $specialization['name'] }}
                                </span>
                                <span class="badge bg-primary">{{ $specialization['years_experience'] }} yrs</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar" style="width: {{ min(100, $specialization['years_experience'] * 10) }}%"></div>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-2x text-muted mb-3"></i>
                            <p class="text-muted small">No specializations added yet</p>
                            <a href="#" class="btn btn-sm btn-primary">
                                Add Specializations
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Reviews</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentReviews as $review)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                    <small class="text-muted">
                                        {{ Str::limit($review->review, 50) }}
                                    </small>
                                    <div class="mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? ' text-warning' : ' text-muted' }} small"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="badge {{ $review->status === 'approved' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($review->status) }}
                                </span>
                            </div>
                            @empty
                            <div class="list-group-item text-center py-4">
                                <i class="fas fa-star fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-2">No reviews yet</p>
                                <small class="text-muted">Reviews will appear here</small>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Blog Posts</h5>
                        <a href="{{ route('blog-posts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentBlogPosts as $post)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-file-alt text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ Str::limit($post->title, 40) }}</h6>
                                    <small class="text-muted">
                                        {{ $post->created_at->diffForHumans() }}
                                        @if($post->category)
                                        • {{ $post->category->name }}
                                        @endif
                                    </small>
                                    <div class="mt-1">
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-eye me-1"></i>{{ $post->view_count }}
                                        </span>
                                    </div>
                                </div>
                                <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                            @empty
                            <div class="list-group-item text-center py-4">
                                <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-2">No blog posts yet</p>
                                <a href="{{ route('blog-posts.create') }}" class="btn btn-sm btn-primary">
                                    Create First Post
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Activity & Time Tracking -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Recent Activities</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentActivities as $activity)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-history text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-capitalize">{{ str_replace('_', ' ', $activity->activity_type) }}</h6>
                                    <small class="text-muted">
                                        {{ $activity->description }}
                                    </small>
                                    <div class="mt-1">
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="list-group-item text-center py-4">
                                <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No recent activities</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Profile & Analytics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-4">
                            <div class="col-4">
                                <div class="border-end">
                                    <h4 class="text-primary">
                                        {{ $timeSpentData->avg('avg_time') > 0 ? round($timeSpentData->avg('avg_time') / 60, 1) : 0 }}m
                                    </h4>
                                    <small class="text-muted">Avg. Time/Visit</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <h4 class="text-success">
                                        {{ $timeSpentData->sum('total_time') > 0 ? round($timeSpentData->sum('total_time') / 3600, 1) : 0 }}h
                                    </h4>
                                    <small class="text-muted">Total Tracked</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <h4 class="text-info">{{ $recentVisitors->count() }}</h4>
                                <small class="text-muted">Recent Visitors</small>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Profile Completion</span>
                                <span>{{ $profileCompletion }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $profileCompletion }}%"
                                     role="progressbar">
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                @if($profileCompletion < 100)
                                    Complete your profile to get more clients
                                @else
                                    Your profile is complete! Great job!
                                @endif
                            </small>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row mt-4 text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h6 class="mb-1">{{ $stats['educations_count'] ?? 0 }}</h6>
                                    <small class="text-muted">Education</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="mb-1">{{ $stats['experiences_count'] ?? 0 }}</h6>
                                <small class="text-muted">Experiences</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Visitors -->
        <div class="row">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Visitors</h5>
                        <span class="badge bg-primary">{{ $recentVisitors->count() }} visitors</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Page Visited</th>
                                        <th>Time Spent</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentVisitors as $visitor)
                                    <tr>
                                        <td>
                                            <code>{{ $visitor->ip_address }}</code>
                                        </td>
                                        <td>
                                            @if($visitor->city && $visitor->country)
                                                {{ $visitor->city }}, {{ $visitor->country }}
                                            @else
                                                <span class="text-muted">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($visitor->page_visited, 30) }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ round($visitor->time_spent / 60, 1) }}m
                                            </span>
                                        </td>
                                        <td>{{ $visitor->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-users fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No visitors yet</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    @if(!empty($visitorChartData))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitorChart').getContext('2d');
            const chartData = @json($visitorChartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Daily Visitors',
                        data: chartData.data,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Visitors'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif
    @endpush

</x-app-layout>