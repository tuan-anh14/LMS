<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_demo_mode()) {
            session()->flash('error', __('site.editing_is_disabled'));
            return response()->json([
                'redirect_to' => route('admin.home'),
            ]);
        }

        return $next($request);
    }
}
