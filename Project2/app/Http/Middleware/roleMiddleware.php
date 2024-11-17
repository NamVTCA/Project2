<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class roleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next, string $role)
        {
            $user = Auth::user();

    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!$user) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập để truy cập.');
    }

    // Kiểm tra vai trò người dùng
    if ($user->role != $role) {
        return abort(403, 'Bạn không có quyền truy cập trang này.');
    }
            return $next($request);
        }
}
