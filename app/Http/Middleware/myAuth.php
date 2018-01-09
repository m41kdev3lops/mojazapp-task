<?php

namespace App\Http\Middleware;

use Closure;

class myAuth
{

    public function handle($request, Closure $next)
    {
        // Check if the user is authorized AND api_token is set in the session to verify that the user is loggedin
        if (!auth()->user() || !session('api_token')) {
            return response()->json("Please login first :(");
        }

        return $next($request);
    }
}
