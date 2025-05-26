<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود معلمة اللغة في المسار
        if ($request->segment(1) === 'locale' && $request->segment(2)) {
            $locale = $request->segment(2);
            if (in_array($locale, ['en', 'ar'])) {
                Session::put('locale', $locale);
                App::setLocale($locale);
            }
        }
        // التحقق من وجود اللغة في الجلسة
        elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // استخدام اللغة الافتراضية
        else {
            App::setLocale(config('app.locale', 'ar'));
            Session::put('locale', config('app.locale', 'ar'));
        }

        return $next($request);
    }
} 