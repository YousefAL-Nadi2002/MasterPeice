@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- معلومات الملف الشخصي -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" 
                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        تعديل الملف الشخصي
                    </button>
                </div>
            </div>

            <!-- معلومات السيارة -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">معلومات السيارة</h5>
                </div>
                <div class="card-body">
                    <p><strong>الموديل:</strong> {{ auth()->user()->car_model }}</p>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCarModal">
                        تحديث معلومات السيارة
                    </button>
                </div>
            </div>
        </div>

        <!-- الحجوزات والنشاطات -->
        <div class="col-md-8">
            <!-- الحجوزات النشطة -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">الحجوزات النشطة</h5>
                </div>
                <div class="card-body">
                    @forelse($activeBookings as $booking)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>{{ $booking->station->name }}</h6>
                                    <p class="text-muted mb-1">
                                        {{ $booking->start_time->format('Y/m/d h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-primary">
                                        التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">لا توجد حجوزات نشطة</p>
                    @endforelse
                </div>
            </div>

            <!-- التقييمات -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">تقييماتي</h5>
                </div>
                <div class="card-body">
                    @forelse($ratings as $rating)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>{{ $rating->station->name }}</h6>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $rating->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-1">{{ $rating->comment }}</p>
                                </div>
                                <small class="text-muted">
                                    {{ $rating->created_at->format('Y/m/d') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">لا توجد تقييمات</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تعديل الملف الشخصي -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل الملف الشخصي</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الصورة الشخصية</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تعديل معلومات السيارة -->
<div class="modal fade" id="editCarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تحديث معلومات السيارة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update.car') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">موديل السيارة</label>
                        <input type="text" class="form-control" name="car_model" 
                               value="{{ auth()->user()->car_model }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 