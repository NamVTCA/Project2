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

        if (!$user) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập.');
        }

        switch ($role) {
            case 0:
                if ($user->role !== 0) {
                    return redirect('/home')->with('error', 'Bạn không có quyền truy cập.');
                }
                break;

            case 1:
                if ($user->role !== 1) {
                    return redirect('/home')->with('error', 'Bạn không có quyền truy cập.');
                }
                break;

            case 2:
                if ($user->role !== 2) {
                    return redirect('/home')->with('error', 'Bạn không có quyền truy cập.');
                }
                break;

            default:
                return redirect('/home')->with('error', 'Quyền truy cập không hợp lệ.');
        }

        return $next($request);
    }
}
