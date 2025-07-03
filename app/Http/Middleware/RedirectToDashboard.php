<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToDashboard
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')) {

                return redirect()->route('admin.home');

            } elseif (auth()->user()->hasRole('teacher')) {

                return redirect()->route('teacher.home');

            } elseif (auth()->user()->hasRole('student')) {

                return redirect()->route('student.home');

            }

            abort(403);

        }

        return redirect()->route('login');

    }

}
