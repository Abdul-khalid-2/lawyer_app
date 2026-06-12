<x-app-layout>
    <!-- Super Admin Dashboard Page -->
    <section id="dashboard" class="page-section active">
        <!-- Welcome Header -->
        <x-dashboard.page-header :title="'Welcome back, ' . Auth::user()->name" icon="fas fa-crown"
            subtitle="Super Admin Dashboard — platform overview & analytics" class="mb-4" />

        <!-- Stats Cards -->
        <div class="row mb-2">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-dashboard.stat-card label="Total Lawyers" :value="$stats['total_lawyers']"
                    icon="fas fa-balance-scale" variant="primary" />
                <small class="text-muted d-block mt-1 ms-1">{{ $stats['verified_lawyers'] }} verified</small>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-dashboard.stat-card label="Blog Posts" :value="$stats['total_blog_posts']"
                    icon="fas fa-blog" variant="success" />
                <small class="text-muted d-block mt-1 ms-1">{{ $stats['published_posts'] }} published</small>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-dashboard.stat-card label="Reviews" :value="$stats['total_reviews']"
                    icon="fas fa-star" variant="warning" />
                <small class="text-muted d-block mt-1 ms-1">{{ $stats['approved_reviews'] }} approved</small>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-dashboard.stat-card label="Platform Visitors" :value="$stats['total_visitors']"
                    icon="fas fa-users" variant="info" />
                <small class="text-muted d-block mt-1 ms-1">{{ $stats['active_specializations'] }} specializations</small>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title">Platform Visitors Growth</h5>
                        <p class="text-muted small">Visitor trends over the past 30 days</p>
                    </div>
                    <div class="card-body">
                        @if($visitorGrowth->count() > 0)
                        <div class="bg-light rounded p-4">
                            <canvas id="visitorGrowthChart" height="250"></canvas>
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
                        <h5 class="card-title">Featured Lawyers</h5>
                        <p class="text-muted small">Top performing lawyers</p>
                    </div>
                    <div class="card-body">
                        @if($popularLawyers->count() > 0)
                            @foreach($popularLawyers as $lawyer)
                            <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}" 
                                         alt="{{ $lawyer->user->name }}" 
                                         class="rounded-circle" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $lawyer->user->name }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="text-warning me-2">
                                            <i class="fas fa-star"></i>
                                            {{ number_format($lawyer->reviews_avg_rating ?? 0, 1) }}
                                        </span>
                                        <span class="text-muted small">
                                            ({{ $lawyer->reviews_count ?? 0 }} reviews)
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $lawyer->visitors_count }} views
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-balance-scale fa-2x text-muted mb-3"></i>
                            <p class="text-muted small">No lawyer data available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities & Blog Posts -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Activities</h5>
                        <span class="badge bg-primary">{{ $recentActivities->count() }} activities</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentActivities as $activity)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-history text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $activity->user->name ?? 'System' }}</h6>
                                    <small class="text-muted">
                                        {{ $activity->description }}
                                    </small>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            {{ $activity->created_at->diffForHumans() }}
                                            • {{ str_replace('_', ' ', $activity->activity_type) }}
                                        </small>
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
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Blog Posts</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
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
                                        By {{ $post->lawyer->user->name }}
                                        • {{ $post->created_at->diffForHumans() }}
                                    </small>
                                    <div class="mt-1">
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-eye me-1"></i>{{ $post->view_count }}
                                        </span>
                                        @if($post->category)
                                        <span class="badge bg-light text-dark">
                                            {{ $post->category->name }}
                                        </span>
                                        @endif
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
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Overview -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Lawyer Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-primary">{{ $stats['verified_lawyers'] }}</h4>
                                    <small class="text-muted">Verified</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success">{{ $stats['featured_lawyers'] }}</h4>
                                <small class="text-muted">Featured</small>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $stats['total_lawyers'] > 0 ? ($stats['verified_lawyers'] / $stats['total_lawyers']) * 100 : 0 }}%"
                                 title="Verification Rate">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $stats['total_lawyers'] > 0 ? round(($stats['verified_lawyers'] / $stats['total_lawyers']) * 100, 1) : 0 }}% verification rate
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Content Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-info">{{ $stats['published_posts'] }}</h4>
                                    <small class="text-muted">Published</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-warning">{{ $stats['approved_reviews'] }}</h4>
                                <small class="text-muted">Approved Reviews</small>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-info" 
                                 style="width: {{ $stats['total_blog_posts'] > 0 ? ($stats['published_posts'] / $stats['total_blog_posts']) * 100 : 0 }}%"
                                 title="Publication Rate">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $stats['total_blog_posts'] > 0 ? round(($stats['published_posts'] / $stats['total_blog_posts']) * 100, 1) : 0 }}% publication rate
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Platform Health</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-success">{{ $stats['active_specializations'] }}</h4>
                                    <small class="text-muted">Active Specializations</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-purple">{{ $popularLawyers->count() }}</h4>
                                <small class="text-muted">Popular Lawyers</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Platform Performance</small>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> Good
                                </small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                                    <i class="fas fa-user-tie fa-2x mb-2"></i>
                                    <span>Manage Lawyers</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="btn btn-outline-success w-100 d-flex flex-column align-items-center py-3">
                                    <i class="fas fa-blog fa-2x mb-2"></i>
                                    <span>Blog Posts</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="btn btn-outline-info w-100 d-flex flex-column align-items-center py-3">
                                    <i class="fas fa-star fa-2x mb-2"></i>
                                    <span>Reviews</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="#" class="btn btn-outline-warning w-100 d-flex flex-column align-items-center py-3">
                                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                    <span>Analytics</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    @if($visitorGrowth->count() > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitorGrowthChart').getContext('2d');
            
            const labels = @json($visitorGrowth->pluck('date'));
            const data = @json($visitorGrowth->pluck('count'));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Visitors',
                        data: data,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5
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