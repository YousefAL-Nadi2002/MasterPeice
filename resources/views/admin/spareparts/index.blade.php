@extends('admin.layouts.app')
@section('title', 'إدارة قطع الغيار')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">جميع قطع الغيار</h5>
                    <a href="{{ route('admin.spareparts.create') }}" class="btn btn-primary">إضافة قطعة جديدة</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>السعر</th>
                                    <th>المخزون</th>
                                    <th>الحالة</th>
                                    <th>صورة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($spareParts as $part)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $part->name }}</td>
                                    <td>{{ Str::limit($part->description, 30) }}</td>
                                    <td>{{ $part->price }} د.أ</td>
                                    <td>{{ $part->stock }}</td>
                                    <td>
                                        @if($part->status == 'available')
                                            <span class="badge bg-success">متوفر</span>
                                        @else
                                            <span class="badge bg-danger">غير متوفر</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($part->image)
                                            <img src="{{ asset('storage/' . $part->image) }}" width="50" height="50" style="object-fit:cover;">
                                        @else
                                            <span class="text-muted">لا يوجد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.spareparts.edit', $part) }}" class="btn btn-sm btn-warning">تعديل</a>
                                        <form action="{{ route('admin.spareparts.destroy', $part) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا توجد قطع غيار</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $spareParts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 