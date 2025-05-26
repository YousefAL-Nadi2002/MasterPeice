<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الحجوزات - شاحنّي</title>
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
                <a href="{{ route('admin.bookings.index') }}" class="active">
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">إدارة الحجوزات</h5>
                        <div>
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">جميع الحالات</option>
                                <option value="pending">قيد الانتظار</option>
                                <option value="confirmed">مؤكدة</option>
                                <option value="completed">مكتملة</option>
                                <option value="cancelled">ملغية</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المستخدم</th>
                                        <th>المحطة</th>
                                        <th>وقت البدء</th>
                                        <th>وقت الانتهاء</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->station->name }}</td>
                                        <td>{{ $booking->start_time->format('Y-m-d H:i') }}</td>
                                        <td>{{ $booking->end_time->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <select class="form-select form-select-sm booking-status" 
                                                    data-booking-id="{{ $booking->id }}"
                                                    style="width: 120px;">
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                    قيد الانتظار
                                                </option>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                                    مؤكدة
                                                </option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                                    مكتملة
                                                </option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                    ملغية
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#viewBookingModal{{ $booking->id }}">
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
        // تحديث حالة الحجز
        document.querySelectorAll('.booking-status').forEach(select => {
            select.addEventListener('change', function() {
                const bookingId = this.dataset.bookingId;
                const newStatus = this.value;

                fetch(`/admin/bookings/${bookingId}/status`, {
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

        // فلترة الحجوزات حسب الحالة
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const statusSelect = row.querySelector('.booking-status');
                if (!status || statusSelect.value === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 