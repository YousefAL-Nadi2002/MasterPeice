@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">إدارة الحجوزات</h6>
                    <div>
                        <button class="btn btn-success me-2" onclick="exportBookings()">
                            <i class="fas fa-file-excel"></i> تصدير Excel
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookingModal">
                            <i class="fas fa-plus"></i> إضافة حجز جديد
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- فلاتر البحث -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="بحث باسم المستخدم" 
                                   id="searchUser">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStation">
                                <option value="">المحطة</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterStatus">
                                <option value="">الحالة</option>
                                <option value="pending">قيد الانتظار</option>
                                <option value="confirmed">مؤكد</option>
                                <option value="completed">مكتمل</option>
                                <option value="cancelled">ملغي</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary w-100" id="resetFilters">
                                إعادة تعيين
                            </button>
                        </div>
                    </div>

                    <!-- جدول الحجوزات -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="bookingsTable">
                            <thead>
                                <tr>
                                    <th>رقم الحجز</th>
                                    <th>المستخدم</th>
                                    <th>المحطة</th>
                                    <th>التاريخ والوقت</th>
                                    <th>المدة</th>
                                    <th>نوع الشاحن</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="text-primary">#{{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $booking->user->avatar ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $booking->user->name }}</h6>
                                                <small class="text-muted">{{ $booking->user->phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $booking->station->name }}</td>
                                    <td>
                                        {{ $booking->start_time->format('Y/m/d') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $booking->start_time->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>{{ $booking->duration }} ساعة</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $booking->charger_type }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($booking->status)
                                            @case('pending')
                                                <span class="badge bg-warning">قيد الانتظار</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-success">مؤكد</span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-info">مكتمل</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">ملغي</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" 
                                                    onclick="viewBooking({{ $booking->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($booking->status == 'pending')
                                                <button class="btn btn-sm btn-success" 
                                                        onclick="confirmBooking({{ $booking->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                                <button class="btn btn-sm btn-danger" 
                                                        onclick="cancelBooking({{ $booking->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- الترقيم -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة حجز -->
<div class="modal fade" id="addBookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة حجز جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المستخدم</label>
                        <select class="form-select" name="user_id" required>
                            <option value="">اختر المستخدم</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المحطة</label>
                        <select class="form-select" name="station_id" required 
                                onchange="updateChargerTypes(this.value)">
                            <option value="">اختر المحطة</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">التاريخ</label>
                            <input type="date" class="form-control" name="date" required 
                                   min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الوقت</label>
                            <input type="time" class="form-control" name="time" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المدة (بالساعات)</label>
                            <input type="number" class="form-control" name="duration" 
                                   min="1" max="4" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الشاحن</label>
                            <select class="form-select" name="charger_type" required id="chargerTypeSelect">
                                <option value="">اختر المحطة أولاً</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ الحجز</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // دوال التعامل مع الحجوزات
    function viewBooking(id) {
        window.location.href = `/admin/bookings/${id}`;
    }

    function confirmBooking(id) {
        if (confirm('هل أنت متأكد من تأكيد هذا الحجز؟')) {
            fetch(`/admin/bookings/${id}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }

    function cancelBooking(id) {
        if (confirm('هل أنت متأكد من إلغاء هذا الحجز؟')) {
            fetch(`/admin/bookings/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }

    function exportBookings() {
        window.location.href = '/admin/bookings/export';
    }

    // تحديث أنواع الشواحن عند اختيار المحطة
    function updateChargerTypes(stationId) {
        if (!stationId) {
            document.getElementById('chargerTypeSelect').innerHTML = '<option value="">اختر المحطة أولاً</option>';
            return;
        }

        fetch(`/api/stations/${stationId}/charger-types`)
            .then(response => response.json())
            .then(types => {
                const select = document.getElementById('chargerTypeSelect');
                select.innerHTML = '';
                types.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type;
                    option.textContent = type;
                    select.appendChild(option);
                });
            });
    }

    // فلترة الجدول
    document.getElementById('searchUser').addEventListener('input', filterTable);
    document.getElementById('filterStation').addEventListener('change', filterTable);
    document.getElementById('filterStatus').addEventListener('change', filterTable);
    document.getElementById('filterDate').addEventListener('change', filterTable);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);

    function filterTable() {
        const user = document.getElementById('searchUser').value.toLowerCase();
        const station = document.getElementById('filterStation').value;
        const status = document.getElementById('filterStatus').value;
        const date = document.getElementById('filterDate').value;
        
        const rows = document.querySelectorAll('#bookingsTable tbody tr');
        
        rows.forEach(row => {
            const userName = row.querySelector('h6').textContent.toLowerCase();
            const stationName = row.querySelector('td:nth-child(3)').textContent;
            const bookingStatus = row.querySelector('.badge').textContent;
            const bookingDate = row.querySelector('td:nth-child(4)').textContent.split('\n')[0].trim();
            
            const userMatch = userName.includes(user);
            const stationMatch = !station || stationName === station;
            const statusMatch = !status || bookingStatus === status;
            const dateMatch = !date || bookingDate === date;
            
            row.style.display = userMatch && stationMatch && statusMatch && dateMatch ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('searchUser').value = '';
        document.getElementById('filterStation').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterDate').value = '';
        filterTable();
    }
</script>
@endpush
@endsection 