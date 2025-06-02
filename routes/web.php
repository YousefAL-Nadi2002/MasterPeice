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
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\BookingController;

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
Route::get('/stations/{station}', [SiteController::class, 'showStation'])->name('stations.show');
Route::get('/about-us', [SiteController::class, 'aboutUs'])->name('about-us');
Route::get('/maintenance', [\App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance');
Route::get('/autoparts', [\App\Http\Controllers\SparePartController::class, 'index'])->name('auto.parts');
Route::get('/content', function () {
    return view('content');
})->name('content');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/autoparts/{id}', [\App\Http\Controllers\SparePartController::class, 'show'])->name('autoparts.show');

// مسارات المصادقة
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
    Route::put('/profile', [SiteController::class, 'updateProfile'])->name('profile.update');
    Route::get('/my-bookings', [SiteController::class, 'myBookings'])->name('my-bookings');
    Route::get('/my-maintenance-requests', [SiteController::class, 'myMaintenanceRequests'])->name('my-maintenance-requests');
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');
});

// مسارات الحجوزات للمستخدمين
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// مسارات لوحة التحكم
Route::prefix('admin')->name('admin.')->group(function () {
    // مسار الجذر لمجموعة المشرفين
    Route::get('/', function () {
        if (auth()->guard('web')->check() && auth()->user()->isAdmin()) { // Assuming you have an isAdmin() method on your User model
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login');
        }
    });

    // مسارات تسجيل دخول المشرف
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // مسارات المشرف المحمية
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // مسارات المحطات
        Route::resource('stations', AdminStationController::class);
        
        // مسارات الحجوزات للمشرف
        Route::resource('bookings', AdminBookingController::class)->names('bookings');
        
        // مسارات طلبات الصيانة
        Route::resource('maintenance', AdminMaintenanceController::class)->except(['create', 'store']);
        
        // مسارات التقارير
        Route::resource('reports', ReportController::class);
        
        // مسارات المستخدمين
        Route::resource('users', AdminUserController::class);

        // مسارات الإعدادات
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // مسارات الإشعارات
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

        // مسارات الخدمات
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

        Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

        // مسارات قطع الغيار
        Route::resource('spareparts', App\Http\Controllers\Admin\SparePartController::class);
    });
});