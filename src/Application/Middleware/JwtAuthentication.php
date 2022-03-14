<?php

namespace App\Application\Middleware;

use App\Util\JWTManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JwtAuthentication implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // 토큰 안 들어왔을 때 예외 처리 필요
        $token = $request->getHeader('Authorization')["0"];
        $userId = 0;
        if (isset($token)) {
            $userId = JWTManager::getInstance()->verifyToken($token);
        }
        $request = $request->withParsedBody(['user_id'=> $userId]);

        return $handler->handle($request);
    }

}
