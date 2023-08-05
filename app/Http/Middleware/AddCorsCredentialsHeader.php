<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCorsCredentialsHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->header('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}
