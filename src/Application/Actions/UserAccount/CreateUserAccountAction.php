<?php

namespace App\Application\Actions\UserAccount;

use App\Domain\UserAccount\CreateUserAccount;
use App\Service\UserAccount\SignUpUserAccountService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateUserAccountAction
{
    private SignUpUserAccountService $signUpUserAccountService;

    public function __construct(SignUpUserAccountService $signUpUserAccountService) {
        $this->signUpUserAccountService = $signUpUserAccountService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body= $request->getParsedBody();
        // 회원가입 Service로 이동
        $result = $this->signUpUserAccountService->createUserAccount(new CreateUserAccount(
            $body['nation_id'], $body['language_id'], $body['name']
            , $body['email'], $body['password']));

        $response->getBody()->write(json_encode($result));
        return $response;
    }
}