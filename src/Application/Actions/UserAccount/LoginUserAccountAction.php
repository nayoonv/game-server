<?php

namespace App\Application\Actions\UserAccount;

use App\Service\UserAccount\LoginUserAccountService;
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
        $result = $this->loginUserAccountService->login($email, $password);

        $response->getBody()->write(json_encode($result));
        return $response;
    }
}