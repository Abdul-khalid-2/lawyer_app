    <!-- Header -->
    <header class="header d-flex align-items-center justify-content-between px-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-link me-3" onclick="toggleSidebar()" id="sidebarToggle">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
            <h5 class="mb-0 text-gray-800" id="pageTitle">Dashboard</h5>
        </div>

        <div class="d-flex align-items-center">
            @role('lawyer')
                <div class="dropdown">
                    <button class="btn btn-link d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->profile_image ? asset('website/' . Auth::user()->profile_image) : 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop&crop=face' }}"
                            alt="{{ Auth::user()->name }}" class="rounded-circle me-2" width="32" height="32">
                        <span class="text-gray-700 d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ms-2 text-gray-500"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('lawyer.profile.show') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('lawyer.profile.edit') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endrole

            @hasanyrole('super_admin|client')
                <div class="dropdown">
                    <button class="btn btn-link d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->profile_image ? asset('website/' . Auth::user()->profile_image) : 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop&crop=face' }}"
                            alt="{{ Auth::user()->name }}" class="rounded-circle me-2" width="32" height="32">
                        <span class="text-gray-700 d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ms-2 text-gray-500"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endhasanyrole

        </div>
    </header>