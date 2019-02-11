<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Authenticate
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
		$authenticated = session('authenticated');

		if( !isset($authenticated) || $authenticated !== true ) {
			return redirect("/login");
		}
		
        return $next($request);
    }
}
