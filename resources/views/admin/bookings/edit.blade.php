@extends('admin.layouts.app')

@section('title', 'تعديل الحجز')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل الحجز</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">المستخدم</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id" required>
                                        <option value="">اختر المستخدم</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="station_id" class="form-label">المحطة</label>
                                    <select class="form-select @error('station_id') is-invalid @enderror" 
                                            id="station_id" name="station_id" required>
                                        <option value="">اختر المحطة</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}" 
                                                {{ old('station_id', $booking->station_id) == $station->id ? 'selected' : '' }}>
                                                {{ $station->name }} ({{ $station->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('station_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">وقت البدء</label>
                                    <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" name="start_time" 
                                           value="{{ old('start_time', $booking->start_time->format('Y-m-d\TH:i')) }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">وقت الانتهاء</label>
                                    <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" name="end_time" 
                                           value="{{ old('end_time', $booking->end_time->format('Y-m-d\TH:i')) }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">اختر الحالة</option>
                                        <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                        <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                        <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_price" class="form-label">السعر الإجمالي</label>
                                    <input type="number" step="0.01" class="form-control @error('total_price') is-invalid @enderror" 
                                           id="total_price" name="total_price" 
                                           value="{{ old('total_price', $booking->total_price) }}" required>
                                    @error('total_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 