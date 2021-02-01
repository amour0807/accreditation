<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\HasRolesAndPermissions;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if(!auth()->user()->hasPermission($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
