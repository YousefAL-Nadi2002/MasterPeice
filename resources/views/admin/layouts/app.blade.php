<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #1e293b !important;
            padding-top: 1rem;
        }
        .sidebar .nav-link,
        .sidebar .nav-link i {
            color: #f3f4f6 !important;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff !important;
            background-color: rgba(255,255,255,0.08) !important;
        }
        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: #f8f9fa !important;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .navbar-brand img {
            height: 40px;
        }
        .user-dropdown img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .card.bg-dark {
            background-color: #243447 !important;
            color: #f3f4f6 !important;
            border: none;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo-shahni.png') }}" alt="" class="img-fluid" style="max-width: 150px;">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                لوحة التحكم
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.stations.*') ? 'active' : '' }}" href="{{ route('admin.stations.index') }}">
                                <i class="fas fa-charging-station"></i>
                                المحطات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}" href="{{ route('admin.maintenance.index') }}">
                                <i class="fas fa-tools"></i>
                                طلبات الصيانة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i>
                                المستخدمين
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                                <i class="fas fa-calendar-check"></i>
                                الحجوزات
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.services.index') }}">
                                <i class="fas fa-concierge-bell"></i>
                                جميع الخدمات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.spareparts.index') }}">
                                <i class="fas fa-cogs"></i>
                                قطع الغيار
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.services.index') }}?type=maintenance">
                                <i class="fas fa-wrench"></i>
                                الصيانة الدورية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.services.index') }}?type=help">
                                <i class="fas fa-ambulance"></i>
                                المساعدة الطارئة
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #1e293b; color: #fff;">
                    <div class="container-fluid">
                        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}" style="color: #38b6ff; font-size: 2rem; letter-spacing: 2px;">
                        <i class="fas fa-charging-station"></i> <span>شاحني</span>
                        </a>
                        <div class="d-flex align-items-center">
                            <span class="me-3">{{ auth()->user()->name }}</span>
                            <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" alt="User Avatar" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 