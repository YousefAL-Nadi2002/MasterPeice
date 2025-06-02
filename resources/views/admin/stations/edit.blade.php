@extends('admin.layouts.app')

@section('title', 'تعديل المحطة')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل المحطة</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.stations.update', $station) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">اسم المحطة</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $station->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">الموقع</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location', $station->location) }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">خط العرض</label>
                                    <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude', $station->latitude) }}" required>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">خط الطول</label>
                                    <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude', $station->longitude) }}" required>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="charger_type" class="form-label">نوع الشاحن</label>
                                    <select class="form-select @error('charger_type') is-invalid @enderror" 
                                            id="charger_type" name="charger_type" required>
                                        <option value="">اختر نوع الشاحن</option>
                                        <option value="Type 1" {{ old('charger_type', $station->charger_type) == 'Type 1' ? 'selected' : '' }}>Type 1</option>
                                        <option value="Type 2" {{ old('charger_type', $station->charger_type) == 'Type 2' ? 'selected' : '' }}>Type 2</option>
                                        <option value="CCS" {{ old('charger_type', $station->charger_type) == 'CCS' ? 'selected' : '' }}>CCS</option>
                                        <option value="CHAdeMO" {{ old('charger_type', $station->charger_type) == 'CHAdeMO' ? 'selected' : '' }}>CHAdeMO</option>
                                    </select>
                                    @error('charger_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="power_output" class="form-label">قوة الشحن (كيلوواط)</label>
                                    <input type="number" class="form-control @error('power_output') is-invalid @enderror" 
                                           id="power_output" name="power_output" value="{{ old('power_output', $station->power_output) }}" required>
                                    @error('power_output')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_per_hour" class="form-label">السعر لكل ساعة</label>
                                    <input type="number" step="0.01" class="form-control @error('price_per_hour') is-invalid @enderror" 
                                           id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour', $station->price_per_hour) }}" required>
                                    @error('price_per_hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">اختر الحالة</option>
                                        <option value="active" {{ old('status', $station->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status', $station->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                        <option value="maintenance" {{ old('status', $station->status) == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $station->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 