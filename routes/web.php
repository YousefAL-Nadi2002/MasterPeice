<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StationController as AdminStationController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// مسارات تغيير اللغة
Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        return redirect(url()->previous())->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate']);
    }
    return redirect()->back();
})->name('locale');

// مسارات الموقع العام
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/map', [SiteController::class, 'map'])->name('map');
Route::get('/nearest', [SiteController::class, 'nearest'])->name('nearest');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/help', [SiteController::class, 'help'])->name('help');
Route::get('/location', [SiteController::class, 'location'])->name('location');
Route::get('/stations', [SiteController::class, 'stations'])->name('stations');
Route::get('/about-us', [SiteController::class, 'aboutUs'])->name('about-us');
Route::get('/maintenance', [SiteController::class, 'maintenance'])->name('maintenance');
Route::get('/autoparts', function () {
    return view('autoparts');
})->name('auto.parts');
Route::get('/content', function () {
    return view('content');
})->name('content');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// مسارات المصادقة
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
    Route::put('/profile', [SiteController::class, 'updateProfile'])->name('profile.update');
    Route::get('/my-bookings', [SiteController::class, 'myBookings'])->name('my-bookings');
    Route::get('/my-maintenance-requests', [SiteController::class, 'myMaintenanceRequests'])->name('my-maintenance-requests');
});

// مسارات لوحة التحكم
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // لوحة التحكم
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // المحطات
    Route::resource('stations', AdminStationController::class, ['as' => 'admin']);
    Route::post('stations/{station}/toggle', [AdminStationController::class, 'toggle'])->name('admin.stations.toggle');
    Route::get('stations/{station}/ports', [AdminStationController::class, 'ports'])->name('admin.stations.ports');
    Route::post('stations/{station}/ports', [AdminStationController::class, 'updatePorts'])->name('admin.stations.ports.update');

    // الحجوزات
    Route::resource('bookings', AdminBookingController::class, ['as' => 'admin']);
    Route::post('bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('admin.bookings.confirm');
    Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('admin.bookings.export');

    // الصيانة
    Route::resource('maintenance', AdminMaintenanceController::class, ['as' => 'admin']);
    Route::post('maintenance/{request}/start', [AdminMaintenanceController::class, 'start'])->name('admin.maintenance.start');
    Route::post('maintenance/{request}/complete', [AdminMaintenanceController::class, 'complete'])->name('admin.maintenance.complete');
    Route::post('maintenance/{request}/cancel', [AdminMaintenanceController::class, 'cancel'])->name('admin.maintenance.cancel');

    // المستخدمين
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // التقارير
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('reports/bookings', [ReportController::class, 'bookings'])->name('admin.reports.bookings');
    Route::get('reports/maintenance', [ReportController::class, 'maintenance'])->name('admin.reports.maintenance');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('admin.reports.revenue');

    // الإعدادات
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // الإشعارات
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('admin.notifications.mark-all-read');
    Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('admin.notifications.mark-read');
});