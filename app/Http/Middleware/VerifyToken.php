<?php

namespace App\Http\Middleware;

use App\Helper\JwtToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JwtToken::verifyToken($token);

        if ($result == 'Unauthorized' || $result == 'token invalid') {
            return response('You are not authorized');
        } else {
            $request->headers->set('user_id', $result->user_id);
            $request->headers->set('user_email', $result->user_email);
            return $next($request);
        }
    }
}
