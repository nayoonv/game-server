<?php

namespace App\Application\Actions\GiftBox;

use App\Service\UserGiftBox\UserGiftBoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReadUserGiftBoxAction
{
    private UserGiftBoxService $userGiftBoxService;

    public function __construct(UserGiftBoxService $userGiftBoxService) {
        $this->userGiftBoxService = $userGiftBoxService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $userGiftBoxList = $this->userGiftBoxService->readUserGiftBox($userId);

        $response->getBody()->write(json_encode($userGiftBoxList, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}