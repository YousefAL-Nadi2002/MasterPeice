@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تعديل الملف الشخصي</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-4">
                        <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="mb-3">
                            <label for="avatar" class="form-label">تغيير الصورة الشخصية</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">تغيير كلمة المرور</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>
@endsection 