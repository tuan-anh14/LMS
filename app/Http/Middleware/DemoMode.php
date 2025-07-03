<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoMode
{

    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.demo_mode')) {
            dd('dsadasdsa');

            if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {

                session()->flash('success', __('site.added_successfully'));
                return redirect()->back();
                //return response()->json(['message' => 'Action disabled in demo mode'], 403);
            }
        }
        /*if (is_demo_mode()) {
            session()->flash('error', __('site.editing_is_disabled'));

            return response()->json([
                'redirect_to' => route('admin.home'),
            ]);
        }*/

        // Proceed with the normal editing functionality


        return $next($request);
    }
}
