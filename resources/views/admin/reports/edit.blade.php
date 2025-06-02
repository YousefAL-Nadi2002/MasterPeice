@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>تعديل التقرير</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">العنوان</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $report->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="form-control-label">نوع التقرير</label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">اختر نوع التقرير</option>
                                        <option value="financial" {{ old('type', $report->type) == 'financial' ? 'selected' : '' }}>مالي</option>
                                        <option value="operational" {{ old('type', $report->type) == 'operational' ? 'selected' : '' }}>تشغيلي</option>
                                        <option value="maintenance" {{ old('type', $report->type) == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                        <option value="performance" {{ old('type', $report->type) == 'performance' ? 'selected' : '' }}>أداء</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="form-control-label">المحتوى</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" name="content" rows="5" required>{{ old('content', $report->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-control-label">الحالة</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">اختر الحالة</option>
                                        <option value="active" {{ old('status', $report->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="draft" {{ old('status', $report->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                                        <option value="archived" {{ old('status', $report->status) == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">تحديث التقرير</button>
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 