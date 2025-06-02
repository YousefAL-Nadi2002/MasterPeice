@extends('admin.layouts.app')
@section('title', 'تعديل طلب الصيانة')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل طلب الصيانة</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.update', $maintenance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="station_id" class="form-label">المحطة</label>
                            <select class="form-select @error('station_id') is-invalid @enderror" id="station_id" name="station_id" required>
                                <option value="">اختر المحطة</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ old('station_id', $maintenance->station_id) == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                            @error('station_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المشكلة</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $maintenance->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="pending" {{ old('status', $maintenance->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="in_progress" {{ old('status', $maintenance->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ old('status', $maintenance->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 