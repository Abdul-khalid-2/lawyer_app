    <!-- Header -->
    <header class="header d-flex align-items-center justify-content-between px-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-link me-3" onclick="toggleSidebar()" id="sidebarToggle">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
            <h5 class="mb-0 text-gray-800" id="pageTitle">Dashboard</h5>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown me-3">
                <button class="btn btn-link position-relative" data-bs-toggle="dropdown">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.6rem;">
                        3
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">New order received</a></li>
                    <li><a class="dropdown-item" href="#">Product out of stock</a></li>
                    <li><a class="dropdown-item" href="#">Customer message</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-link d-flex align-items-center" data-bs-toggle="dropdown">
                    <img src="https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop&crop=face"
                        alt="User" class="rounded-circle me-2" width="32" height="32">
                    <span class="text-gray-700 d-none d-sm-inline">Admin User</span>
                    <i class="fas fa-chevron-down ms-2 text-gray-500"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href=""><i class="fas fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href=""><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </header>