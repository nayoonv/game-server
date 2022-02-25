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
        $hiveId = $request->getParsedBody()['hive_id'];

        $userInfo = $this->loginUserAccountService->getUserInfo($hiveId);

        $response->getBody()->write(json_encode($userInfo->jsonSerialize()));

        return $response;
    }
}