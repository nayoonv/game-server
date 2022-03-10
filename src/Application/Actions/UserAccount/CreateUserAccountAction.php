<?php

namespace App\Application\Actions\UserAccount;

use App\Domain\UserAccount\CreateUserAccount;
use App\Service\UserAccount\CreateUserAccountService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateUserAccountAction
{
    private CreateUserAccountService $createUserAccountService;

    public function __construct(CreateUserAccountService $createUserAccountService) {
        $this->createUserAccountService = $createUserAccountService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $params = $request->getParsedBody();
        $result = $this->createUserAccountService->createUserAccount(new CreateUserAccount(
            $params['nation_id'], $params['language_id'], $params['name']
            , $params['email'], $params['password']));

        $response->getBody()->write($result);
        return $response;
    }
}