@extends('admin.layouts.app')
@section('title', 'إضافة طلب صيانة جديد')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إضافة طلب صيانة جديد</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="station_id" class="form-label">المحطة</label>
                            <select class="form-select @error('station_id') is-invalid @enderror" id="station_id" name="station_id" required>
                                <option value="">اختر المحطة</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                            @error('station_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المشكلة</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 