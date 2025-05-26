<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إدارة المحطات - شاحنّي</title>
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
                <a href="{{ route('admin.stations.index') }}" class="active">
                    <i class="bi bi-ev-station"></i> المحطات
                </a>
                <a href="{{ route('admin.bookings.index') }}">
                    <i class="bi bi-calendar-check"></i> الحجوزات
                </a>
                <a href="{{ route('admin.maintenance.index') }}">
                    <i class="bi bi-tools"></i> الصيانة
                </a>
                <a href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> المستخدمين
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
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">إدارة المحطات</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStationModal">
                            <i class="bi bi-plus-lg"></i> إضافة محطة جديدة
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المحطة</th>
                                        <th>الموقع</th>
                                        <th>الحالة</th>
                                        <th>عدد الحجوزات</th>
                                        <th>طلبات الصيانة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stations as $station)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $station->name }}</td>
                                        <td>{{ $station->location }}</td>
                                        <td>
                                            @switch($station->status)
                                                @case('active')
                                                    <span class="badge bg-success">نشطة</span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="badge bg-warning">صيانة</span>
                                                    @break
                                                @case('inactive')
                                                    <span class="badge bg-danger">متوقفة</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $station->bookings_count }}</td>
                                        <td>{{ $station->maintenance_requests_count }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editStationModal{{ $station->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteStation({{ $station->id }})">
                                                <i class="bi bi-trash"></i>
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

    <!-- Add Station Modal -->
    <div class="modal fade" id="addStationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة محطة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.stations.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">اسم المحطة</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الموقع</label>
                            <input type="text" class="form-control" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status" required>
                                <option value="active">نشطة</option>
                                <option value="maintenance">صيانة</option>
                                <option value="inactive">متوقفة</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteStation(id) {
            if (confirm('هل أنت متأكد من حذف هذه المحطة؟')) {
                // Send delete request
                fetch(`/admin/stations/${id}`, {
                    method: 'DELETE',
                    headers: {
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