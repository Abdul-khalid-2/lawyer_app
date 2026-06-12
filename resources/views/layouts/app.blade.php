<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · Law-Skoolyst</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Centralized dashboard design system -->
    @vite(['resources/css/dashboard/dashboard.css', 'resources/js/dashboard/dashboard.js'])
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
