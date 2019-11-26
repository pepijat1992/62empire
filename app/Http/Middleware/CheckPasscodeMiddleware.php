<?php

namespace App\Http\Middleware;

use Closure;

class CheckPasscodeMiddleware
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
        if(!$request->session()->get('passcode')){
            return redirect(route('check_passcode'));
        }
        return $next($request);
    }
}
