// تحديث حالة الحجز
function updateBookingStatus(bookingId, newStatus) {
    if (confirm('هل أنت متأكد من تغيير حالة الحجز؟')) {
        fetch(`/admin/bookings/${bookingId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
        }).then(response => {
            if (response.ok) {
                showAlert('success', 'تم تحديث حالة الحجز بنجاح');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('error', 'حدث خطأ أثناء تحديث حالة الحجز');
            }
        });
    }
}

// تحديث حالة طلب الصيانة
function updateMaintenanceStatus(requestId, newStatus) {
    if (confirm('هل أنت متأكد من تغيير حالة طلب الصيانة؟')) {
        fetch(`/admin/maintenance/${requestId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
        }).then(response => {
            if (response.ok) {
                showAlert('success', 'تم تحديث حالة طلب الصيانة بنجاح');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('error', 'حدث خطأ أثناء تحديث حالة طلب الصيانة');
            }
        });
    }
}

// حذف محطة
function deleteStation(id) {
    if (confirm('هل أنت متأكد من حذف هذه المحطة؟ سيتم حذف جميع البيانات المرتبطة بها.')) {
        fetch(`/admin/stations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) {
                showAlert('success', 'تم حذف المحطة بنجاح');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('error', 'حدث خطأ أثناء حذف المحطة');
            }
        });
    }
}

// تغيير حالة المستخدم
function toggleUserStatus(userId) {
    if (confirm('هل أنت متأكد من تغيير حالة هذا المستخدم؟')) {
        fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) {
                showAlert('success', 'تم تحديث حالة المستخدم بنجاح');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('error', 'حدث خطأ أثناء تحديث حالة المستخدم');
            }
        });
    }
}

// عرض تنبيه
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const mainContent = document.querySelector('.main-content');
    mainContent.insertBefore(alertDiv, mainContent.firstChild);
    
    // إخفاء التنبيه بعد 3 ثواني
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// البحث في الجداول
function tableSearch(inputId, tableId) {
    const input = document.getElementById(inputId);
    const filter = input.value.toLowerCase();
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const text = cell.textContent || cell.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}

// تصدير البيانات إلى Excel
function exportToExcel(tableId, fileName) {
    const table = document.getElementById(tableId);
    const ws = XLSX.utils.table_to_sheet(table, {raw: true});
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
    XLSX.writeFile(wb, `${fileName}.xlsx`);
}

// إضافة مربع البحث للجداول
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('.table');
    tables.forEach(table => {
        if (table.id) {
            const searchBox = document.createElement('div');
            searchBox.className = 'search-box';
            searchBox.innerHTML = `
                <div class="input-group">
                    <input type="text" class="form-control" id="search_${table.id}" 
                           placeholder="ابحث..." onkeyup="tableSearch('search_${table.id}', '${table.id}')">
                    <button class="btn btn-outline-secondary" type="button" 
                            onclick="exportToExcel('${table.id}', '${table.id}_export')">
                        <i class="bi bi-file-earmark-excel"></i> تصدير
                    </button>
                </div>
            `;
            table.parentNode.insertBefore(searchBox, table);
        }
    });
});