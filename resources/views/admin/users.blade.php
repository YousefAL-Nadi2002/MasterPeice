<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - شاحنّي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar a.active {
            background-color: #0d6efd;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-white text-center mb-4">لوحة التحكم</h4>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> الرئيسية
                </a>
                <a href="{{ route('admin.stations.index') }}">
                    <i class="bi bi-ev-station"></i> المحطات
                </a>
                <a href="{{ route('admin.bookings.index') }}">
                    <i class="bi bi-calendar-check"></i> الحجوزات
                </a>
                <a href="{{ route('admin.maintenance.index') }}">
                    <i class="bi bi-tools"></i> الصيانة
                </a>
                <a href="{{ route('admin.users.index') }}" class="active">
                    <i class="bi bi-people"></i> المستخدمين
                </a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">إدارة المستخدمين</h5>
                        <div>
                            <input type="text" class="form-control form-control-sm" id="searchInput" 
                                   placeholder="بحث عن مستخدم..." style="width: 200px;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>عدد الحجوزات</th>
                                        <th>آخر نشاط</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $user->bookings_count }}</td>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'لم يسجل دخول' }}</td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">مفعل</span>
                                            @else
                                                <span class="badge bg-warning">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#viewUserModal{{ $user->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" onclick="toggleUserStatus({{ $user->id }})">
                                                <i class="bi bi-person-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // بحث في المستخدمين
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                if (name.includes(searchText) || email.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // تغيير حالة المستخدم (تفعيل/تعطيل)
        function toggleUserStatus(userId) {
            if (confirm('هل أنت متأكد من تغيير حالة هذا المستخدم؟')) {
                fetch(`/admin/users/${userId}/toggle-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html> 