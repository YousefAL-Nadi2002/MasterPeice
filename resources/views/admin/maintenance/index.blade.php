@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">طلبات الصيانة</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>المحطة</th>
                        <th>المشكلة</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenanceRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->station->name }}</td>
                        <td>{{ Str::limit($request->description, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'in_progress' ? 'warning' : ($request->status === 'cancelled' ? 'danger' : 'info')) }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.maintenance.show', $request) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.maintenance.destroy', $request) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $maintenanceRequests->links() }}
        </div>
    </div>
</div>
@endsection 