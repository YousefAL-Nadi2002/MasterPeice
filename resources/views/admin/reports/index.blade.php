@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>التقارير</h6>
                        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary btn-sm">
                            إضافة تقرير جديد
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">العنوان</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">النوع</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الحالة</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">تاريخ الإنشاء</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $report->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $report->type }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-{{ $report->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $report->created_at->format('Y-m-d') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-link text-dark px-3 mb-0">
                                                <i class="fas fa-pencil-alt text-dark me-2"></i>تعديل
                                            </a>
                                            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                                    <i class="far fa-trash-alt me-2"></i>حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 