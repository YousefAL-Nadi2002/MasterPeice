@extends('admin.layouts.app')

@section('title', 'إضافة محطة جديدة')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إضافة محطة جديدة</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.stations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">اسم المحطة</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name_ar" class="form-label">اسم المحطة (بالعربية)</label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar') }}">
                                    @error('name_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">خط العرض</label>
                                    <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">خط الطول</label>
                                    <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">العنوان</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address_ar" class="form-label">العنوان (بالعربية)</label>
                                    <input type="text" class="form-control @error('address_ar') is-invalid @enderror" id="address_ar" name="address_ar" value="{{ old('address_ar') }}">
                                    @error('address_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">المدينة</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city_ar" class="form-label">المدينة (بالعربية)</label>
                                    <input type="text" class="form-control @error('city_ar') is-invalid @enderror" id="city_ar" name="city_ar" value="{{ old('city_ar') }}">
                                    @error('city_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_ports" class="form-label">عدد المنافذ الكلي</label>
                                    <input type="number" class="form-control @error('total_ports') is-invalid @enderror" id="total_ports" name="total_ports" value="{{ old('total_ports', 0) }}" min="0">
                                    @error('total_ports')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="available_ports" class="form-label">عدد المنافذ المتاحة</label>
                                    <input type="number" class="form-control @error('available_ports') is-invalid @enderror" id="available_ports" name="available_ports" value="{{ old('available_ports', 0) }}" min="0">
                                    @error('available_ports')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="charging_types" class="form-label">أنواع الشحن</label>
                                    <select class="form-select @error('charging_types') is-invalid @enderror" id="charging_types" name="charging_types[]" multiple>
                                        <option value="Type 2">Type 2</option>
                                        <option value="CCS">CCS</option>
                                        <option value="CHAdeMO">CHAdeMO</option>
                                        <option value="Tesla">Tesla</option>
                                    </select>
                                    @error('charging_types')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amenities" class="form-label">المرافق</label>
                                    <select class="form-select @error('amenities') is-invalid @enderror" id="amenities" name="amenities[]" multiple>
                                        <option value="restroom">حمام</option>
                                        <option value="cafe">كافيه</option>
                                        <option value="restaurant">مطعم</option>
                                        <option value="wifi">واي فاي</option>
                                        <option value="shopping">تسوق</option>
                                    </select>
                                    @error('amenities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="opening_time" class="form-label">وقت الفتح</label>
                                    <input type="time" class="form-control @error('opening_time') is-invalid @enderror" id="opening_time" name="opening_time" value="{{ old('opening_time') }}">
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="closing_time" class="form-label">وقت الإغلاق</label>
                                    <input type="time" class="form-control @error('closing_time') is-invalid @enderror" id="closing_time" name="closing_time" value="{{ old('closing_time') }}">
                                    @error('closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">رقم الاتصال</label>
                                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_number" class="form-label">رقم الطوارئ</label>
                                    <input type="text" class="form-control @error('emergency_number') is-invalid @enderror" id="emergency_number" name="emergency_number" value="{{ old('emergency_number') }}">
                                    @error('emergency_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 