@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- إحصائيات سريعة -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">المحطات النشطة</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $activeStations }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-primary text-white rounded-circle">
                                <i class="fas fa-charging-station"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">الحجوزات اليوم</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $todayBookings }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-success text-white rounded-circle">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">طلبات الصيانة</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $pendingMaintenance }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-warning text-white rounded-circle">
                                <i class="fas fa-tools"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">المستخدمين النشطين</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $activeUsers }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-info text-white rounded-circle">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الحجوزات الأخيرة -->
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">الحجوزات الأخيرة</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>المحطة</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->station->name }}</td>
                                    <td>{{ $booking->start_time->format('Y/m/d H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status_color }}">
                                            {{ $booking->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="btn btn-sm btn-primary">
                                            التفاصيل
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- التقييمات الأخيرة -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">آخر التقييمات</h6>
                </div>
                <div class="card-body">
                    @foreach($recentRatings as $rating)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <img src="{{ $rating->user->avatar ?? asset('images/default-avatar.png') }}" 
                                 class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $rating->user->name }}</h6>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $rating->rating ? '' : '-o' }} small"></i>
                                @endfor
                            </div>
                            <small class="text-muted">{{ $rating->station->name }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- إحصائيات المحطات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">إحصائيات المحطات</h6>
                </div>
                <div class="card-body">
                    <canvas id="stationsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- إحصائيات الحجوزات -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">إحصائيات الحجوزات</h6>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // رسم بياني للمحطات
    const stationsCtx = document.getElementById('stationsChart').getContext('2d');
    new Chart(stationsCtx, {
        type: 'doughnut',
        data: {
            labels: ['نشطة', 'صيانة', 'متوقفة'],
            datasets: [{
                data: [{{ $stationsStats->active }}, {{ $stationsStats->maintenance }}, {{ $stationsStats->inactive }}],
                backgroundColor: ['#2dce89', '#fb6340', '#f5365c']
            }]
        }
    });

    // رسم بياني للحجوزات
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingsStats->labels) !!},
            datasets: [{
                label: 'الحجوزات',
                data: {!! json_encode($bookingsStats->data) !!},
                borderColor: '#5e72e4',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection