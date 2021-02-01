<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class isGuest
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
         //check if logged in
        // if (!Auth::guard('alumni')->check()) {
        //     return redirect()->route('login');
        // }

        //check user type
        if(auth()->guard('alumni')->user()->user_role == 'graduate'){
            return $next($request);
        }
   
        abort(404);
    }
}
