<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - شاحنّي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            width: inherit;
            display: flex;
            flex-direction: column;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #495057;
            padding-right: 20px;
        }
        .sidebar a.active {
            background-color: #0d6efd;
            border-right: 4px solid #fff;
        }
        .main-content {
            margin-right: 16.666667%;
            padding: 20px;
        }
        .stats-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card h2 {
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .table th {
            font-weight: 600;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,0.125);
            padding: 15px 20px;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 0 2px;
        }
        .logout-link {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-white text-center mb-4">لوحة التحكم</h4>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> الرئيسية
                </a>
                <a href="{{ route('admin.stations.index') }}" class="{{ request()->routeIs('admin.stations.*') ? 'active' : '' }}">
                    <i class="bi bi-ev-station"></i> المحطات
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> الحجوزات
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="{{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i> الصيانة
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> المستخدمين
                </a>
                <a href="javascript:void(0)" onclick="logout()" class="logout-link">
                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                </a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @foreach($unreadNotifications as $notification)
                    <div>{{ $notification->data['title'] ?? 'إشعار جديد' }}</div>
                @endforeach

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <script>
        // تعريف دالة showAlert العامة
        function showAlert(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: type === 'success' ? 'success' : 'error',
                title: message
            });
        }
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
    @stack('scripts')
</body>
</html> 