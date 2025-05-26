// التحقق من حالة تسجيل الدخول
function checkAuthStatus() {
    fetch('/api/auth/check', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (!data.authenticated || !data.is_admin) {
            window.location.href = '/login';
        }
    })
    .catch(error => {
        console.error('Error checking auth status:', error);
        showAlert('error', 'حدث خطأ أثناء التحقق من حالة تسجيل الدخول');
    });
}

// تسجيل الخروج
function logout() {
    Swal.fire({
        title: 'تأكيد تسجيل الخروج',
        text: 'هل أنت متأكد من تسجيل الخروج؟',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'نعم، تسجيل الخروج',
        cancelButtonText: 'إلغاء',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '/login';
                } else {
                    throw new Error('Logout failed');
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
                showAlert('error', 'حدث خطأ أثناء تسجيل الخروج');
            });
        }
    });
}

// التحقق من حالة تسجيل الدخول عند تحميل الصفحة وكل 5 دقائق
document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
    setInterval(checkAuthStatus, 300000);
});