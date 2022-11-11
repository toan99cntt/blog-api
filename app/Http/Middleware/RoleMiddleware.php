<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Repositories\RoleRepository;
use Illuminate\Auth\AuthenticationException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @throws Exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$names)
    {
        /** @var Member $user */
        $user = $request->user();
        /** @var RoleRepository $roleRepository */
        $roleRepository = app(RoleRepository::class);
        $rolesId = $roleRepository->findByNames($names)->pluck('id')->toArray();

        if ($user->checkRoleIn($rolesId)) {
            return $next($request);
        }

        throw new AuthenticationException();
    }
}
