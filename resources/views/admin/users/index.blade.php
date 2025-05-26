@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">إدارة المستخدمين</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> إضافة مستخدم جديد
                    </button>
                </div>
                <div class="card-body">
                    <!-- فلاتر البحث -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="بحث بالاسم أو البريد" 
                                   id="searchUser">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterRole">
                                <option value="">الدور</option>
                                <option value="admin">مشرف</option>
                                <option value="user">مستخدم</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">الحالة</option>
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                                <option value="blocked">محظور</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-secondary w-100" id="resetFilters">
                                إعادة تعيين
                            </button>
                        </div>
                    </div>

                    <!-- جدول المستخدمين -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="usersTable">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>موديل السيارة</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->car_model }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-primary">مشرف</span>
                                        @else
                                            <span class="badge bg-info">مستخدم</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($user->status)
                                            @case('active')
                                                <span class="badge bg-success">نشط</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge bg-warning">غير نشط</span>
                                                @break
                                            @case('blocked')
                                                <span class="badge bg-danger">محظور</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $user->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" 
                                                    onclick="viewUser({{ $user->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary" 
                                                    onclick="editUser({{ $user->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($user->status !== 'blocked')
                                                <button class="btn btn-sm btn-danger" 
                                                        onclick="blockUser({{ $user->id }})">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success" 
                                                        onclick="unblockUser({{ $user->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- الترقيم -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة مستخدم -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مستخدم جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الصورة الشخصية</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">موديل السيارة</label>
                        <input type="text" class="form-control" name="car_model">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="isAdmin">
                            <label class="form-check-label" for="isAdmin">
                                مشرف النظام
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ المستخدم</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // دوال التعامل مع المستخدمين
    function viewUser(id) {
        window.location.href = `/admin/users/${id}`;
    }

    function editUser(id) {
        window.location.href = `/admin/users/${id}/edit`;
    }

    function blockUser(id) {
        if (confirm('هل أنت متأكد من حظر هذا المستخدم؟')) {
            fetch(`/admin/users/${id}/block`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }

    function unblockUser(id) {
        if (confirm('هل أنت متأكد من إلغاء حظر هذا المستخدم؟')) {
            fetch(`/admin/users/${id}/unblock`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }

    // فلترة الجدول
    document.getElementById('searchUser').addEventListener('input', filterTable);
    document.getElementById('filterRole').addEventListener('change', filterTable);
    document.getElementById('filterStatus').addEventListener('change', filterTable);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);

    function filterTable() {
        const search = document.getElementById('searchUser').value.toLowerCase();
        const role = document.getElementById('filterRole').value;
        const status = document.getElementById('filterStatus').value;
        
        const rows = document.querySelectorAll('#usersTable tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('h6').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const userRole = row.querySelector('td:nth-child(5) .badge').textContent;
            const userStatus = row.querySelector('td:nth-child(6) .badge').textContent;
            
            const searchMatch = name.includes(search) || email.includes(search);
            const roleMatch = !role || userRole.toLowerCase() === role;
            const statusMatch = !status || userStatus.toLowerCase() === status;
            
            row.style.display = searchMatch && roleMatch && statusMatch ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('searchUser').value = '';
        document.getElementById('filterRole').value = '';
        document.getElementById('filterStatus').value = '';
        filterTable();
    }
</script>
@endpush
@endsection 