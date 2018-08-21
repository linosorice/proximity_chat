<?php

namespace App\Http\Middleware;

use Illuminate\Session\Middleware;
use Closure;

class ApiAuthorization
{
    public function handle($request, Closure $next)
    {
		$token = $request->header('Authorization');
		if ($token=="" or !validateToken($token)) {
			return response()->json(apiResult(null, "Unauthorized access"), 401);
		}
		
		return $next($request);
    }
}
