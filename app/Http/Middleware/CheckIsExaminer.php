<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsExaminer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has is_examiner flag
        if (auth()->check() && auth()->user()->is_examiner) {
            return $next($request);
        }

        // If not examiner, redirect back with error
        return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này.');
    }
}
