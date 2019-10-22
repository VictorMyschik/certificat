<?php

namespace App\Http\Middleware;

use App\Models\MrUser;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($mr_user = MrUser::me()) {
            if (!$mr_user->IsAdmin()) {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }

        return $next($request);
    }
}
