<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - {{ config('app.name') }}</title>

    <!-- الخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- الأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">

    <!-- نمط مخصص -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }

        /* القائمة الجانبية */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 250px;
            background: #1e293b !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .sidebar-brand {
            color: #5e72e4;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            padding: 0 20px;
            margin-bottom: 5px;
        }

        .nav-link {
            color:rgb(255, 255, 255);
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #5e72e4;
            background: rgba(94,114,228,0.1);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-left: 10px;
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-right: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* البطاقات */
        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }

        /* الأزرار */
        .btn {
            border-radius: 5px;
            padding: 8px 16px;
        }

        .btn-primary {
            background-color: #5e72e4;
            border-color: #5e72e4;
        }

        .btn-primary:hover {
            background-color: #4454c3;
            border-color: #4454c3;
        }

        /* الأيقونات الدائرية */
        .icon-shape {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        /* الإشعارات */
        .dropdown-menu {
            min-width: 280px;
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .dropdown-item {
            padding: 10px 15px;
        }

        /* الشريط العلوي */
        .navbar {
            background: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 15px 20px;
        }

        .navbar-brand img {
            height: 40px;
        }

        /* التنقل المتجاوب */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
            }

            .navbar-toggler {
                display: block;
            }
        }

        /* الجداول */
        .table th {
            font-weight: 600;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        /* شريط التقدم */
        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
            height: 5px;
        }

        /* الشارات */
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* الرسوم البيانية */
        canvas {
            max-width: 100%;
        }

        /* النماذج */
        .form-control {
            border-radius: 5px;
            padding: 8px 12px;
        }

        .form-control:focus {
            border-color: #5e72e4;
            box-shadow: 0 0 0 0.2rem rgba(94,114,228,0.25);
        }

        /* التنبيهات */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* الصور */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- القائمة الجانبية -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="fas fa-charging-station"></i> <span>شاحني</span>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stations.index') }}" class="nav-link {{ request()->routeIs('admin.stations.*') ? 'active' : '' }}">
                        <i class="fas fa-charging-station"></i>
                        المحطات
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        الحجوزات
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.maintenance.index') }}" class="nav-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                        <i class="fas fa-tools"></i>
                        الصيانة
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        المستخدمين
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        التقارير
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        الإعدادات
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- الشريط العلوي -->
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
                <i class="fas fa-bars"></i>
            </button>

        </nav>

        <!-- المحتوى -->
        @yield('content')
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- سكربت مخصص -->
    <script>
        // تبديل القائمة الجانبية
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // إخفاء القائمة الجانبية عند النقر خارجها في الشاشات الصغيرة
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const navbarToggler = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                !navbarToggler.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });

        // تمرير الإشعارات كمقروءة
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const notificationId = this.dataset.id;
                if (notificationId) {
                    fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html> 