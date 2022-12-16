<?php

namespace App\Http\Middleware;

use App\Helpers\Formatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(Formatter::response(401, 'Unauthorized'), 401);
        }
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST');
    }
}
