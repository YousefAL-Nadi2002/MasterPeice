@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">إدارة المحطات</h6>
                    <a href="{{ route('admin.stations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة محطة جديدة
                    </a>
                </div>
                <div class="card-body">
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

                    <!-- فلاتر البحث -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="بحث بالاسم" 
                                   id="searchName">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">الحالة</option>
                                <option value="active">نشطة</option>
                                <option value="maintenance">صيانة</option>
                                <option value="inactive">متوقفة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterCharger">
                                <option value="">نوع الشاحن</option>
                                @foreach($chargerTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-secondary w-100" id="resetFilters">
                                إعادة تعيين
                            </button>
                        </div>
                    </div>

                    <!-- جدول المحطات -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="stationsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الموقع</th>
                                    <th>المنافذ</th>
                                    <th>أنواع الشواحن</th>
                                    <th>التقييم</th>
                                    <th>الحالة</th>
                                    <th>عدد الحجوزات</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($stations ?? []) as $station)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $station->image ?? asset('images/default-station.png') }}" 
                                                 class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $station->name }}</h6>
                                                <small class="text-muted">ID: {{ $station->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="https://maps.google.com/?q={{ $station->latitude }},{{ $station->longitude }}" 
                                           target="_blank" class="text-primary">
                                            عرض على الخريطة
                                        </a>
                                    </td>
                                    <td>
                                        {{ $station->available_ports }}/{{ $station->total_ports }}
                                    </td>
                                    <td>
                                        @foreach((array) $station->charging_types as $type)
                                            <span class="badge bg-info me-1">{{ $type }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $station->average_rating ? '' : '-o' }} small"></i>
                                            @endfor
                                            <small class="text-muted">({{ $station->total_ratings }})</small>
                                        </div>
                                    </td>
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
                                    <td>
                                        {{ $station->bookings_count ?? 0 }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.stations.edit', $station) }}" 
                                                    title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.stations.destroy', $station) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه المحطة؟');"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">لا توجد محطات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- الترقيم -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $stations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // دوال التعامل مع المحطات
    function viewStation(id) {
        window.location.href = `/admin/stations/${id}`;
    }

    function editStation(id) {
        window.location.href = `/admin/stations/${id}/edit`;
    }

    function deleteStation(id) {
        if (confirm('هل أنت متأكد من حذف هذه المحطة؟')) {
            fetch(`/admin/stations/${id}`, {
                method: 'DELETE',
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

    // فلترة الجدول
    document.getElementById('searchName').addEventListener('input', filterTable);
    document.getElementById('filterStatus').addEventListener('change', filterTable);
    document.getElementById('filterCharger').addEventListener('change', filterTable);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);

    function filterTable() {
        const name = document.getElementById('searchName').value.toLowerCase();
        const status = document.getElementById('filterStatus').value;
        const charger = document.getElementById('filterCharger').value;
        
        const rows = document.querySelectorAll('#stationsTable tbody tr');
        
        rows.forEach(row => {
            const stationName = row.querySelector('h6').textContent.toLowerCase();
            const stationStatus = row.querySelector('.badge').textContent;
            const chargerTypes = Array.from(row.querySelectorAll('.badge.bg-info'))
                                    .map(badge => badge.textContent);
            
            const nameMatch = stationName.includes(name);
            const statusMatch = !status || stationStatus === status;
            const chargerMatch = !charger || chargerTypes.includes(charger);
            
            row.style.display = nameMatch && statusMatch && chargerMatch ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('searchName').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterCharger').value = '';
        filterTable();
    }
</script>
@endpush
@endsection 