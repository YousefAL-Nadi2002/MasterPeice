@extends('admin.layouts.app')

@section('title', 'إضافة خدمة جديدة')

@section('content')
<div class="container">
    <h1>إضافة خدمة جديدة</h1>
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">اسم الخدمة</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">السعر</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label for="sort_order" class="form-label">الترتيب</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">صورة الخدمة</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>مفعل</option>
                <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>معطل</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection 