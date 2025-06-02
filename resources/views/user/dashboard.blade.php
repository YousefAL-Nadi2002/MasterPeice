@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم')

@section('content')
<div class="container">
    <h1>لوحة تحكم المستخدم</h1>
    <p>مرحباً بك في لوحة تحكمك. يمكنك إدارة حسابك وحجوزاتك من هنا.</p>
    <ul>
        <li><a href="{{ route('profile') }}">الملف الشخصي</a></li>
        <li><a href="{{ route('my-bookings') }}">حجوزاتي</a></li>
        <li><a href="{{ route('my-maintenance-requests') }}">طلبات الصيانة الخاصة بي</a></li>
    </ul>
</div>
@endsection 