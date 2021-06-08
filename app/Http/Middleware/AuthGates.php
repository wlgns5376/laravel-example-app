<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AuthGates
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
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->isAdmin() || $user->hasPermission($permission->slug);
            });
        }

        Inertia::share('can', function() use ($request, $permissions) {
            $user = $request->user();
            $cans = [];
            foreach ($permissions as $permission) {
                $cans[$permission->slug] = $user && $user->can($permission->slug);
            }
            
            return $cans;
        });

        return $next($request);
    }
}
