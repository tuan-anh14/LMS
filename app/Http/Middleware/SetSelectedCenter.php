<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetSelectedCenter
{
    public function handle(Request $request, Closure $next)
    {
        if (
            session()->has('selected_center') &&
            auth()->user()->teacherAndManagerCenters->contains(session('selected_center'))
        ) {

            return $next($request);

        } else {

            session(['selected_center' => auth()->user()->teacherCenters->first()]);

            return $next($request);

        }

    }
}
