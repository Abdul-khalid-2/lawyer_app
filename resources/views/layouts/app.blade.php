<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            line-height: 1.6;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            color: #cbd5e1 !important;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            transform: translateX(5px);
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .header {
            height: var(--header-height);
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            transition: left 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
        }

        .footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
            margin-top: auto;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .chart-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table th {
            background-color: #f8fafc;
            border: none;
            font-weight: 600;
            color: #475569;
            padding: 1rem;
        }

        .table td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        /* Mobile Responsive */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }

            .header {
                left: var(--sidebar-width);
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        @media (max-width: 767px) {
            .main-content {
                padding: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Collapsed sidebar for desktop */
        @media (min-width: 768px) {
            .sidebar.collapsed {
                width: 70px;
                /* adjust to fit icons */
            }

            .sidebar.collapsed .sidebar-header h4,
            .sidebar.collapsed .sidebar-nav .nav-link span {
                display: none;
                /* hide text */
            }

            .sidebar.collapsed .nav-link {
                text-align: center;
            }

            .sidebar.collapsed .nav-link i {
                margin-right: 0;
            }

            /* shift header and main content */
            .header.collapsed {
                left: 70px;
            }

            .main-content.collapsed {
                margin-left: 70px;
            }
        }

        @media (min-width: 768px) {
            .sidebar {
                overflow: hidden;
                /* ensures text can't overflow */
            }

            .sidebar.collapsed {
                width: 70px;
            }

            /* hide title in header */
            .sidebar.collapsed .sidebar-header h4 {
                display: none;
            }

            /* adjust nav links */
            .sidebar .nav-link {
                display: flex;
                align-items: center;
                white-space: nowrap;
                /* prevents wrapping */
                overflow: hidden;
                /* cut overflowing text */
            }

            .sidebar.collapsed .nav-link span {
                display: none;
                /* hide link text */
            }

            /* icons stay centered */
            .sidebar.collapsed .nav-link {
                justify-content: center;
            }

            /* shift header & content */
            .header.collapsed {
                left: 70px;
            }

            .main-content.collapsed {
                margin-left: 70px;
            }
        }
    </style>
    @stack('css')
</head>

<body>


    @include('layouts.sidebar')

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>


    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="main-content">

        {{ $slot }}

    </main>

    @include('layouts.footer')

    @stack('js')
</body>

</html>