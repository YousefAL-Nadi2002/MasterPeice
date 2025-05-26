@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- تفاصيل المحطة -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="mb-3">{{ $station->name }}</h2>
                    
                    <!-- التقييم والموقع -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $station->average_rating ? '' : '-o' }}"></i>
                            @endfor
                            <span class="text-muted ms-2">({{ $station->total_ratings }} تقييم)</span>
                        </div>
                        <a href="https://maps.google.com/?q={{ $station->latitude }},{{ $station->longitude }}" 
                           target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-map-marker-alt"></i> عرض على الخريطة
                        </a>
                    </div>

                    <!-- معلومات المحطة -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>معلومات المحطة</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-plug me-2"></i> عدد المنافذ: {{ $station->total_ports }}</li>
                                <li><i class="fas fa-battery-half me-2"></i> المنافذ المتاحة: {{ $station->available_ports }}</li>
                                <li>
                                    <i class="fas fa-charging-station me-2"></i> أنواع الشواحن:
                                    <ul>
                                        @foreach($station->charging_types as $type)
                                            <li>{{ $type }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>المرافق</h5>
                            <ul class="list-unstyled">
                                @foreach($station->amenities as $amenity)
                                    <li><i class="fas fa-check me-2"></i> {{ $amenity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="mb-4">
                        <h5>الوصف</h5>
                        <p>{{ $station->description }}</p>
                    </div>

                    <!-- ساعات العمل -->
                    <div>
                        <h5>ساعات العمل</h5>
                        <ul class="list-unstyled">
                            @foreach($station->operating_hours as $day => $hours)
                                <li>{{ $day }}: {{ $hours }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- التقييمات -->
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">التقييمات</h5>
                    @auth
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRatingModal">
                            إضافة تقييم
                        </button>
                    @endauth
                </div>
                <div class="card-body">
                    @forelse($station->ratings()->with('user')->latest()->get() as $rating)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>{{ $rating->user->name }}</h6>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $rating->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    @if($rating->aspects)
                                        <div class="small text-muted mb-2">
                                            @foreach($rating->aspects as $aspect => $score)
                                                <span class="me-3">{{ $aspect }}: {{ $score }}/5</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <p class="mb-1">{{ $rating->comment }}</p>
                                </div>
                                <small class="text-muted">
                                    {{ $rating->created_at->format('Y/m/d') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">لا توجد تقييمات بعد</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- حجز موعد -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">حجز موعد</h5>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="station_id" value="{{ $station->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">التاريخ</label>
                                <input type="date" class="form-control" name="date" required 
                                       min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">الوقت</label>
                                <input type="time" class="form-control" name="time" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">مدة الشحن (بالساعات)</label>
                                <input type="number" class="form-control" name="duration" 
                                       min="1" max="4" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">نوع الشاحن</label>
                                <select class="form-select" name="charger_type" required>
                                    @foreach($station->charging_types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    تأكيد الحجز
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <p>يجب تسجيل الدخول لحجز موعد</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">تسجيل الدخول</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة تقييم -->
@auth
<div class="modal fade" id="addRatingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة تقييم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="station_id" value="{{ $station->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">التقييم العام</label>
                        <div class="rating-stars">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تقييم الجوانب</label>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label small">النظافة</label>
                                <input type="number" class="form-control" name="aspects[cleanliness]" 
                                       min="1" max="5">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small">الخدمة</label>
                                <input type="number" class="form-control" name="aspects[service]" 
                                       min="1" max="5">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small">التوفر</label>
                                <input type="number" class="form-control" name="aspects[availability]" 
                                       min="1" max="5">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small">الموقع</label>
                                <input type="number" class="form-control" name="aspects[location]" 
                                       min="1" max="5">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التعليق</label>
                        <textarea class="form-control" name="comment" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

@push('styles')
<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        cursor: pointer;
        padding: 5px;
        color: #ddd;
    }
    .rating-stars input:checked ~ label {
        color: #ffc107;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107;
    }
</style>
@endpush
@endsection 