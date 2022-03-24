<?php

namespace App\Application\Actions\UserAccount;

use App\Service\UserAccount\LoginUserAccountService;
use App\Util\JWTManager;
use App\Util\SuccessResponseManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginUserAccountAction
{
    private LoginUserAccountService $loginUserAccountService;

    public function __construct(LoginUserAccountService $loginUserAccountService) {
        $this->loginUserAccountService = $loginUserAccountService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $email = $body['email'];
        $password = $body['password'];
        $userInfo = $this->loginUserAccountService->login($email, $password);
        $token = JWTManager::getInstance()->getToken($userInfo->getUserId());
        $result = [
            "user"=>$userInfo,
            "token"=>$token
        ];
        $result = SuccessResponseManager::response($result);
        $response->getBody()->write(json_encode($result));
//        $response->getBody()->write
        return $response;
    }
}