@extends('admin.layouts.app')
@section('title', 'إضافة قطعة غيار جديدة')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إضافة قطعة غيار جديدة</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القطعة</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">السعر (د.أ)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">المخزون</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متوفر</option>
                                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>غير متوفر</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="part_type" class="form-label">نوع القطعة</label>
                            <input type="text" class="form-control @error('part_type') is-invalid @enderror" id="part_type" name="part_type" value="{{ old('part_type') }}">
                            @error('part_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="condition" class="form-label">الحالة</label>
                            <input type="text" class="form-control @error('condition') is-invalid @enderror" id="condition" name="condition" value="{{ old('condition') }}">
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="compatible_with" class="form-label">متوافق مع</label>
                            <input type="text" class="form-control @error('compatible_with') is-invalid @enderror" id="compatible_with" name="compatible_with" value="{{ old('compatible_with') }}">
                            @error('compatible_with')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="extra_description" class="form-label">وصف إضافي</label>
                            <textarea class="form-control @error('extra_description') is-invalid @enderror" id="extra_description" name="extra_description" rows="2">{{ old('extra_description') }}</textarea>
                            @error('extra_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="seller_name" class="form-label">اسم البائع</label>
                            <input type="text" class="form-control @error('seller_name') is-invalid @enderror" id="seller_name" name="seller_name" value="{{ old('seller_name') }}">
                            @error('seller_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">موقع القطعة</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">واتساب</label>
                            <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}">
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">صور إضافية (يمكن اختيار أكثر من صورة)</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.spareparts.index') }}" class="btn btn-secondary">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 