@extends('admin.layouts.app')

@section('title', 'تفاصيل الخدمة')

@section('content')
<div class="container">
    <h1>تفاصيل الخدمة</h1>
    <div class="card">
        <div class="card-body">
            <h3>{{ $service->name }}</h3>
            <p><strong>الوصف:</strong> {{ $service->description }}</p>
            <p><strong>السعر:</strong> {{ $service->price ?? '-' }}</p>
            <p><strong>الترتيب:</strong> {{ $service->sort_order }}</p>
            <p><strong>الحالة:</strong> {{ $service->is_active ? 'مفعل' : 'معطل' }}</p>
            @if($service->image)
                <p><img src="{{ asset('storage/' . $service->image) }}" width="120" height="120" /></p>
            @endif
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">تعديل</a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </div>
</div>
@endsection 