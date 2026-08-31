<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('X-API-KEY') !== env('LICENSE_API_KEY')){
            return ['error' => 'Unauthorized'];
        }
        return $next($request);
    }
}
