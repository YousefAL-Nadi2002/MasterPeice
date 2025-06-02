@extends('admin.layouts.app')

@section('title', 'تعديل خدمة')

@section('content')
<div class="container">
    <h1>تعديل خدمة</h1>
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">اسم الخدمة</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $service->name) }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">السعر</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $service->price) }}">
        </div>
        <div class="mb-3">
            <label for="sort_order" class="form-label">الترتيب</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">صورة الخدمة</label>
            @if($service->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $service->image) }}" width="80" height="80" />
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', $service->is_active) == 1 ? 'selected' : '' }}>مفعل</option>
                <option value="0" {{ old('is_active', $service->is_active) == 0 ? 'selected' : '' }}>معطل</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">تحديث</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection 