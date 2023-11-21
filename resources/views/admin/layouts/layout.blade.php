<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Bootstrap')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <!-- Add your additional styles if needed -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @yield('styles')
    @yield('linksscript')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('admin.dashboard')}}">Zethic Tech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">Home <i class="bi bi-house"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('employee.index')}}">Manage Employee <i class="bi bi-people"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.logout')}}">Logout <i
                            class="bi bi-box-arrow-right"></i></a>
                </li>

                <!-- Add more navigation items as needed -->
            </ul>


        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>
<footer>
    <p class="d-flex justify-content-center">&copy; 2023 Zethic Tech. All rights reserved.</p>
</footer>
<!-- Include Bootstrap JS and any additional scripts if needed -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@yield('scripts')
</body>
</html>
