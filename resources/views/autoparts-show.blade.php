@extends('layouts.app')
@section('content')
<div class="container py-5">
    <a href="{{ route('auto.parts') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-right"></i> العودة إلى القائمة</a>
    <div class="row g-4 align-items-start">
        <div class="col-lg-5">
            <div class="bg-white rounded shadow p-3 text-center">
                <img src="{{ $part->image ? asset('storage/' . $part->image) : 'https://placehold.co/600x400/E9ECEF/343A40?text=لا+توجد+صورة' }}" alt="صورة القطعة" class="img-fluid rounded mb-3" style="max-height:320px;object-fit:contain;">
                @if($part->images)
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        @foreach(json_decode($part->images, true) ?? [] as $img)
                            <img src="{{ asset('storage/' . $img) }}" width="70" height="70" class="rounded border" style="object-fit:cover;">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-7">
            <div class="bg-white rounded shadow p-4 h-100">
                <h2 class="text-primary mb-3">{{ $part->name }}</h2>
                <h5 class="mb-3">معلومات عن القطعة</h5>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-cogs text-info"></i> <strong>نوع القطعة:</strong> {{ $part->part_type }}</li>
                    <li class="mb-2"><i class="fas fa-tags text-info"></i> <strong>الحالة:</strong> {{ $part->condition }}</li>
                    <li class="mb-2"><i class="fas fa-car text-info"></i> <strong>متوافقة مع:</strong> {{ $part->compatible_with }}</li>
                    <li class="mb-2"><i class="fas fa-info-circle text-info"></i> <strong>وصف إضافي:</strong> {{ $part->extra_description }}</li>
                    <li class="mb-2"><i class="fas fa-dollar-sign text-info"></i> <strong>السعر المطلوب:</strong> {{ $part->price }} د.أ</li>
                    <li class="mb-2"><i class="fas fa-user text-info"></i> <strong>اسم البائع:</strong> {{ $part->seller_name }}</li>
                    <li class="mb-2"><i class="fas fa-map-marker-alt text-info"></i> <strong>موقع القطعة:</strong> {{ $part->location }}</li>
                </ul>
                <h5 class="mb-3">معلومات التواصل</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-phone text-success"></i> <strong>الهاتف:</strong> {{ $part->phone }}</li>
                    <li class="mb-2"><i class="fab fa-whatsapp text-success"></i> <strong>واتساب:</strong> {{ $part->whatsapp }}</li>
                    <li class="mb-2"><i class="fas fa-envelope text-primary"></i> <strong>البريد الإلكتروني:</strong> {{ $part->email }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 