@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">إدارة المحطات</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStationModal">
                        <i class="fas fa-plus"></i> إضافة محطة جديدة
                    </button>
                </div>
                <div class="card-body">
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
                                    <th>الاسم</th>
                                    <th>الموقع</th>
                                    <th>المنافذ</th>
                                    <th>أنواع الشواحن</th>
                                    <th>التقييم</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stations as $station)
                                <tr>
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
                                        @foreach($station->charging_types as $type)
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
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" 
                                                    onclick="viewStation({{ $station->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary" 
                                                    onclick="editStation({{ $station->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="deleteStation({{ $station->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

<!-- Modal إضافة محطة -->
<div class="modal fade" id="addStationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة محطة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.stations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المحطة</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الصورة</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">خط العرض</label>
                            <input type="number" class="form-control" name="latitude" 
                                   step="any" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">خط الطول</label>
                            <input type="number" class="form-control" name="longitude" 
                                   step="any" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">عدد المنافذ</label>
                            <input type="number" class="form-control" name="total_ports" 
                                   min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status" required>
                                <option value="active">نشطة</option>
                                <option value="maintenance">صيانة</option>
                                <option value="inactive">متوقفة</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">أنواع الشواحن</label>
                        <div class="row">
                            @foreach($chargerTypes as $type)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="charging_types[]" value="{{ $type }}">
                                        <label class="form-check-label">{{ $type }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المرافق</label>
                        <div class="row">
                            @foreach($amenities as $amenity)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="amenities[]" value="{{ $amenity }}">
                                        <label class="form-check-label">{{ $amenity }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ساعات العمل</label>
                        @foreach(['weekdays', 'weekend'] as $day)
                            <div class="row align-items-center mb-2">
                                <div class="col-md-3">
                                    <label>{{ $day == 'weekdays' ? 'أيام الأسبوع' : 'نهاية الأسبوع' }}</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" 
                                           name="operating_hours[{{ $day }}][start]">
                                </div>
                                <div class="col-md-1 text-center">إلى</div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" 
                                           name="operating_hours[{{ $day }}][end]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ المحطة</button>
                </div>
            </form>
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