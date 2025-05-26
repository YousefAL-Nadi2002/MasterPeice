@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- تقارير سريعة -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">إجمالي الحجوزات</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalBookings }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-success me-2">
                                        <i class="fa fa-arrow-up"></i> {{ $bookingsGrowth }}%
                                    </span>
                                    <span class="text-muted">مقارنة بالشهر السابق</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-primary text-white rounded-circle">
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">متوسط التقييم</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ number_format($averageRating, 1) }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-muted">من {{ $totalRatings }} تقييم</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <div class="icon icon-shape bg-success text-white rounded-circle">
                                <i class="fas fa-star"></i>
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
                                    {{ $totalMaintenance }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-warning me-2">{{ $pendingMaintenance }}</span>
                                    <span class="text-muted">قيد الانتظار</span>
                                </p>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">المستخدمين الجدد</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $newUsers }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-success me-2">
                                        <i class="fa fa-arrow-up"></i> {{ $usersGrowth }}%
                                    </span>
                                    <span class="text-muted">هذا الشهر</span>
                                </p>
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

    <div class="row mb-4">
        <!-- تقرير الحجوزات -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">تقرير الحجوزات</h6>
                        </div>
                        <div class="col text-end">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary btn-sm" onclick="updateBookingsChart('daily')">
                                    يومي
                                </button>
                                <button class="btn btn-outline-primary btn-sm" onclick="updateBookingsChart('weekly')">
                                    أسبوعي
                                </button>
                                <button class="btn btn-outline-primary btn-sm" onclick="updateBookingsChart('monthly')">
                                    شهري
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- تقرير التقييمات -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">تقرير التقييمات</h6>
                </div>
                <div class="card-body">
                    <canvas id="ratingsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- أداء المحطات -->
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">أداء المحطات</h6>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-success btn-sm" onclick="exportStationsReport()">
                                <i class="fas fa-file-excel"></i> تصدير التقرير
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>المحطة</th>
                                    <th>الحجوزات</th>
                                    <th>التقييم</th>
                                    <th>المنافذ النشطة</th>
                                    <th>طلبات الصيانة</th>
                                    <th>معدل الإشغال</th>
                                    <th>الأداء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stationsPerformance as $station)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $station->image ?? asset('images/default-station.png') }}" 
                                                 class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $station->name }}</h6>
                                                <small class="text-muted">{{ $station->location }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $station->total_bookings }}
                                        <small class="text-muted d-block">
                                            {{ $station->completed_bookings }} مكتملة
                                        </small>
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $station->average_rating ? '' : '-o' }} small"></i>
                                            @endfor
                                            <small class="text-muted d-block">
                                                {{ $station->total_ratings }} تقييم
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $station->active_ports }}/{{ $station->total_ports }}
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-success" 
                                                 style="width: {{ ($station->active_ports / $station->total_ports) * 100 }}%">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $station->maintenance_requests }}
                                        <small class="text-muted d-block">
                                            {{ $station->pending_maintenance }} قيد الانتظار
                                        </small>
                                    </td>
                                    <td>
                                        {{ number_format($station->occupancy_rate, 1) }}%
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-info" 
                                                 style="width: {{ $station->occupancy_rate }}%">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($station->performance_score >= 80)
                                            <span class="badge bg-success">ممتاز</span>
                                        @elseif($station->performance_score >= 60)
                                            <span class="badge bg-info">جيد</span>
                                        @elseif($station->performance_score >= 40)
                                            <span class="badge bg-warning">متوسط</span>
                                        @else
                                            <span class="badge bg-danger">ضعيف</span>
                                        @endif
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // رسم بياني للحجوزات
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    const bookingsChart = new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingsChart->labels) !!},
            datasets: [{
                label: 'الحجوزات',
                data: {!! json_encode($bookingsChart->data) !!},
                borderColor: '#5e72e4',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // تحديث بيانات الحجوزات
    function updateBookingsChart(period) {
        fetch(`/admin/reports/bookings/${period}`)
            .then(response => response.json())
            .then(data => {
                bookingsChart.data.labels = data.labels;
                bookingsChart.data.datasets[0].data = data.data;
                bookingsChart.update();
            });
    }

    // رسم بياني للتقييمات
    const ratingsCtx = document.getElementById('ratingsChart').getContext('2d');
    new Chart(ratingsCtx, {
        type: 'doughnut',
        data: {
            labels: ['5 نجوم', '4 نجوم', '3 نجوم', '2 نجوم', '1 نجمة'],
            datasets: [{
                data: {!! json_encode($ratingsDistribution) !!},
                backgroundColor: ['#2dce89', '#5e72e4', '#fb6340', '#ffd600', '#f5365c']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // تصدير تقرير المحطات
    function exportStationsReport() {
        window.location.href = '/admin/reports/stations/export';
    }
</script>
@endpush
@endsection 