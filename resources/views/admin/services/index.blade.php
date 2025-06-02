@extends('admin.layouts.app')

@section('title', 'إدارة الخدمات')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>الخدمات</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">إضافة خدمة جديدة</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>الحالة</th>
                <th>الترتيب</th>
                <th>صورة</th>
                <th>الخيارات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->name }}</td>
                    <td>{{ Str::limit($service->description, 50) }}</td>
                    <td>{{ $service->price ?? '-' }}</td>
                    <td>{{ $service->is_active ? 'مفعل' : 'معطل' }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" width="50" height="50" />
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $services->links() }}
    </div>
</div>
@endsection 