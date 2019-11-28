<?php

namespace App\Http\Middleware;

use Closure;

class AgentPasscodeMiddleware
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
        if(!$request->session()->get('agent_passcode')){
            return redirect(route('agent.check_passcode'));
        }
        return $next($request);
    }
}
