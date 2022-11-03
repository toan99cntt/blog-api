<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddDataResponse
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
        $request->merge(
            [
                'grant_type' => 'password',
                'client_secret' => config('auth.api_client_secret'),
                'client_id' => config('auth.api_client_id'),
                'scope' => '',
            ]
        );

        return $next($request);
    }
}
