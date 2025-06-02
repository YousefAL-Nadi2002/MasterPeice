@extends('admin.layouts.app')

@section('title', 'لوحة تحكم الأدمن')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(90deg, #38b6ff 0%, #1e293b 100%);
        color: #fff;
        border-radius: 1rem;
        padding: 2rem 2rem 1rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 24px rgba(56,182,255,0.10);
        text-align: center;
    }
    .stat-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(30,41,59,0.08);
        transition: transform 0.2s;
        background: #fff;
    }
    .stat-card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 8px 32px rgba(56,182,255,0.15);
    }
    .stat-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 1rem auto;
        font-size: 2.2rem;
        color: #fff;
        box-shadow: 0 2px 8px rgba(30,41,59,0.10);
    }
    .stat-blue { background: linear-gradient(135deg, #38b6ff 60%, #1e293b 100%);}
    .stat-green { background: linear-gradient(135deg, #22c55e 60%, #16a34a 100%);}
    .stat-orange { background: linear-gradient(135deg, #f59e42 60%, #fbbf24 100%);}
    .stat-red { background: linear-gradient(135deg, #ef4444 60%, #b91c1c 100%);}
    .stat-title { font-size: 1.1rem; color: #1e293b; font-weight: 600;}
    .stat-value { font-size: 2.2rem; font-weight: bold; color: #1e293b;}
    .table-card { border-radius: 1rem; box-shadow: 0 2px 16px rgba(30,41,59,0.08);}
    .service-card {
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(30,41,59,0.08);
        background: #fff;
        padding: 1.5rem;
        margin-bottom: 1rem;
        text-align: center;
        transition: box-shadow 0.2s;
    }
    .service-card:hover {
        box-shadow: 0 8px 32px rgba(56,182,255,0.15);
    }
    .service-icon {
        font-size: 2.5rem;
        color: #38b6ff;
        margin-bottom: 0.5rem;
    }
    .quick-link-card {
        border-radius: 1rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .quick-link-card:hover {
        box-shadow: 0 8px 32px rgba(56,182,255,0.15);
        transform: translateY(-5px) scale(1.03);
    }
</style>

<div class="dashboard-header mb-5">
    <img src="{{ asset('images/logo.png') }}" alt="" style="height: 60px; margin-bottom: 10px;">
    <h1 class="fw-bold mb-2" style="font-size:2.5rem;"> <span style="font-size:1.2rem; color:#fbbf24;">لوحة تحكم الأدمن</span></h1>
    <p class="mb-0" style="font-size:1.1rem;">مرحباً بك في لوحة التحكم. يمكنك إدارة النظام من هنا</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card text-center">
            <div class="stat-icon stat-blue mb-2">
                <i class="fas fa-charging-station"></i>
            </div>
            <div class="stat-title">المحطات</div>
            <div class="stat-value">{{ $stats['total_stations'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-center">
            <div class="stat-icon stat-green mb-2">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-title">المستخدمون</div>
            <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-center">
            <div class="stat-icon stat-orange mb-2">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-title">الحجوزات</div>
            <div class="stat-value">{{ $stats['total_bookings'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-center">
            <div class="stat-icon stat-red mb-2">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-title">طلبات الصيانة</div>
            <div class="stat-value">{{ $stats['total_maintenance_requests'] ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card table-card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-chart-line me-2"></i>حجوزات آخر 7 أيام</div>
            <div class="card-body">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card table-card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-chart-pie me-2"></i>حالات المحطات</div>
            <div class="card-body">
                <canvas id="stationsChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header bg-white fw-bold"><i class="fas fa-list me-2"></i>جميع خدمات الموقع</div>
            <div class="card-body">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-md-4">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="{{ $service->icon ?? 'fas fa-cogs' }}"></i>
                                </div>
                                <h5 class="fw-bold">{{ $service->name }}</h5>
                                <p class="text-muted">{{ $service->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row g-4">
    <div class="col-md-6">
        <div class="card table-card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-history me-2"></i>أحدث الحجوزات</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>المحطة</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recent_bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->station->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'success' : 'secondary') }}">{{ $booking->status }}</span></td>
                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card table-card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-wrench me-2"></i>أحدث طلبات الصيانة</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>المحطة</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recent_maintenance as $req)
                        <tr>
                            <td>{{ $req->station->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $req->status == 'pending' ? 'warning' : ($req->status == 'in_progress' ? 'info' : ($req->status == 'completed' ? 'success' : 'secondary')) }}">{{ $req->status }}</span></td>
                            <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // بيانات الحجوزات
    const bookingsLabels = @json($bookingsStats->labels ?? []);
    const bookingsData = @json($bookingsStats->data ?? []);
    // بيانات المحطات
    const stationsData = @json([$stationsStats->active ?? 0, $stationsStats->maintenance ?? 0, $stationsStats->inactive ?? 0]);

    // رسم مخطط الحجوزات
    new Chart(document.getElementById('bookingsChart'), {
        type: 'line',
        data: {
            labels: bookingsLabels,
            datasets: [{
                label: 'عدد الحجوزات',
                data: bookingsData,
                borderColor: '#38b6ff',
                backgroundColor: 'rgba(56,182,255,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // رسم مخطط حالات المحطات
    new Chart(document.getElementById('stationsChart'), {
        type: 'doughnut',
        data: {
            labels: ['نشطة', 'صيانة', 'غير نشطة'],
            datasets: [{
                data: stationsData,
                backgroundColor: ['#22c55e', '#f59e42', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
@endsection