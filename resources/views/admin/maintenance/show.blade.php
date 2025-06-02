@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تفاصيل طلب الصيانة</h5>
        <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <h6>معلومات المستخدم</h6>
                    <p><strong>الاسم:</strong> {{ $maintenanceRequest->user->name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $maintenanceRequest->user->email }}</p>
                    <p><strong>رقم الهاتف:</strong> {{ $maintenanceRequest->user->phone }}</p>
                </div>

                <div class="mb-4">
                    <h6>معلومات المحطة</h6>
                    <p><strong>اسم المحطة:</strong> {{ $maintenanceRequest->station->name }}</p>
                    <p><strong>العنوان:</strong> {{ $maintenanceRequest->station->address }}</p>
                    <p><strong>نوع الشاحن:</strong> {{ $maintenanceRequest->station->charger_type }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <h6>تفاصيل الطلب</h6>
                    <p><strong>الحالة:</strong> 
                        <span class="badge bg-{{ $maintenanceRequest->status === 'completed' ? 'success' : ($maintenanceRequest->status === 'in_progress' ? 'warning' : ($maintenanceRequest->status === 'cancelled' ? 'danger' : 'info')) }}">
                            {{ $maintenanceRequest->status }}
                        </span>
                    </p>
                    <p><strong>تاريخ الطلب:</strong> {{ $maintenanceRequest->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>آخر تحديث:</strong> {{ $maintenanceRequest->updated_at->format('Y-m-d H:i') }}</p>
                </div>

                <div class="mb-4">
                    <h6>وصف المشكلة</h6>
                    <p>{{ $maintenanceRequest->description }}</p>
                </div>

                @if($maintenanceRequest->admin_notes)
                <div class="mb-4">
                    <h6>ملاحظات المسؤول</h6>
                    <p>{{ $maintenanceRequest->admin_notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('admin.maintenance.update', $maintenanceRequest) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">تحديث الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ $maintenanceRequest->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="in_progress" {{ $maintenanceRequest->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ $maintenanceRequest->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ $maintenanceRequest->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">ملاحظات المسؤول</label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $maintenanceRequest->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 