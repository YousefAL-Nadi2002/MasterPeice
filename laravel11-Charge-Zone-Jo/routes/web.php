<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/Home', function () {
    return view('Home');
});

Route::get('/map', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/nearest', function () {
    return view('nearest');
});
Route::get('/about', function () {
    return view('welcome');
});
Route::get('/contact', function () {
    return view('welcome');
});
Route::get('/help', function () {
    return view('help');
});
Route::get('/', function () {
    return view('welcome');
});







// صفحة الخريطة
Route::get('/map', 'App\Http\Controllers\SiteController@map')->name('map');

// صفحة أقرب محطة
Route::get('/nearest', 'App\Http\Controllers\SiteController@nearest')->name('nearest');

// صفحة حول الموقع
Route::get('/about', 'App\Http\Controllers\SiteController@about')->name('about');

// صفحة اتصل بنا
Route::get('/contact', 'App\Http\Controllers\SiteController@contact')->name('contact');