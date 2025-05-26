<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة طلبات الصيانة - شاحنّي</title>
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
        .emergency {
            background-color: #fff3f3;
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
                <a href="{{ route('admin.maintenance.index') }}" class="active">
                    <i class="bi bi-tools"></i> الصيانة
                </a>
                <a href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> المستخدمين
                </a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">إدارة طلبات الصيانة</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" id="typeFilter" style="width: 150px;">
                                <option value="">جميع الأنواع</option>
                                <option value="emergency">طارئ</option>
                                <option value="scheduled">مجدول</option>
                                <option value="repair">إصلاح</option>
                            </select>
                            <select class="form-select form-select-sm" id="statusFilter" style="width: 150px;">
                                <option value="">جميع الحالات</option>
                                <option value="pending">قيد الانتظار</option>
                                <option value="in_progress">قيد التنفيذ</option>
                                <option value="completed">مكتمل</option>
                                <option value="cancelled">ملغي</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المحطة</th>
                                        <th>النوع</th>
                                        <th>الوصف</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                    <tr class="{{ $request->type == 'emergency' ? 'emergency' : '' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $request->station->name }}</td>
                                        <td>
                                            @switch($request->type)
                                                @case('emergency')
                                                    <span class="badge bg-danger">طارئ</span>
                                                    @break
                                                @case('scheduled')
                                                    <span class="badge bg-info">مجدول</span>
                                                    @break
                                                @case('repair')
                                                    <span class="badge bg-warning">إصلاح</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ Str::limit($request->description, 50) }}</td>
                                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <select class="form-select form-select-sm maintenance-status" 
                                                    data-request-id="{{ $request->id }}"
                                                    style="width: 120px;">
                                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>
                                                    قيد الانتظار
                                                </option>
                                                <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>
                                                    قيد التنفيذ
                                                </option>
                                                <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>
                                                    مكتمل
                                                </option>
                                                <option value="cancelled" {{ $request->status == 'cancelled' ? 'selected' : '' }}>
                                                    ملغي
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#viewRequestModal{{ $request->id }}">
                                                <i class="bi bi-eye"></i>
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
        // تحديث حالة طلب الصيانة
        document.querySelectorAll('.maintenance-status').forEach(select => {
            select.addEventListener('change', function() {
                const requestId = this.dataset.requestId;
                const newStatus = this.value;

                fetch(`/admin/maintenance/${requestId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                }).then(response => {
                    if (response.ok) {
                        // يمكن إضافة إشعار نجاح هنا
                    }
                });
            });
        });

        // فلترة الطلبات حسب النوع والحالة
        function filterRequests() {
            const type = document.getElementById('typeFilter').value;
            const status = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const typeCell = row.querySelector('td:nth-child(3)');
                const statusSelect = row.querySelector('.maintenance-status');
                
                const typeMatch = !type || typeCell.textContent.includes(type);
                const statusMatch = !status || statusSelect.value === status;

                row.style.display = typeMatch && statusMatch ? '' : 'none';
            });
        }

        document.getElementById('typeFilter').addEventListener('change', filterRequests);
        document.getElementById('statusFilter').addEventListener('change', filterRequests);
    </script>
</body>
</html> 