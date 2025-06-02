<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }
            return redirect()->route('admin.login')->with('error', 'يجب أن تكون مشرفاً للوصول إلى لوحة التحكم');
        }

        return $next($request);
    }
}