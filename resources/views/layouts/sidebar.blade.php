    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}">
                 <h4 class="text-white mb-0">
                    Consultent Lawyers
                </h4>
            </a>
           
            <button class="btn btn-link d-md-none p-0" onclick="closeSidebar()" style="color: white;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-nav list-unstyled">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            @role('super_admin')
                <div class="nav-item">
                    <a href="{{ route('admin.cases.index') }}" class="nav-link {{ request()->routeIs('admin.cases.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i>
                        <span>Cases</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.clients.index') }}" class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                        <i class="fas fa-user-friends"></i>
                        <span>Clients</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('lawyers.index') }}" class="nav-link {{ request()->routeIs('lawyers.*') ? 'active' : '' }}">
                        <i class="fas fa-gavel"></i>
                        <span>Lawyers</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span>Users</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('specializations.index') }}" class="nav-link {{ request()->routeIs('specializations.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Specialization</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('blog-categories.index') }}" class="nav-link {{ request()->routeIs('blog-categories.*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span>Blogs Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('pages.index') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        <span>CMS Pages</span>
                    </a>
                </div>
            @endrole

            @role('lawyer')
                <div class="nav-item">
                    <a href="{{ route('schedule.index') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Schedule</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('clients.index') }}" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <span>Clients</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('cases.index') }}" class="nav-link">
                        <i class="fas fa-briefcase"></i>
                        <span>Cases</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('team-members.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>My Team</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('blog-posts.index') }}" class="nav-link">
                        <i class="fas fa-gavel"></i>
                        <span>Blogs</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('videos.index') }}" class="nav-link">
                         <i class="fas fa-video"></i>
                        <span>Videos</span>
                    </a>
                </div>
            @endrole

            @role('client')
                <div class="nav-item">
                    <a href="{{ route('client.cases.index') }}" class="nav-link">
                        <i class="fas fa-briefcase"></i>
                        <span>My Cases</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('client.schedule') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Schedule</span>
                    </a>
                </div>
            @endrole
        </ul>
    </nav>