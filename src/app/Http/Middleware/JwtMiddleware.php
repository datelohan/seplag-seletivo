<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'Usuário não encontrado'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'Token não encontrado'], 401);
        }

        return $next($request);
    }
}