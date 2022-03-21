<?php

namespace App\Application\Actions\GiftBox;

use App\Service\UserGiftBox\UserGiftBoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserGiftBoxReceivedAction
{
    private UserGiftBoxService $userGiftBoxService;

    public function __construct(UserGiftBoxService $userGiftBoxService) {
        $this->userGiftBoxService = $userGiftBoxService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $userGiftBoxId = $body['user_gift_box_id'];

        $this->userGiftBoxService->updateUserGiftBox($userGiftBoxId);
        $result = "선물을수령하였습니다.";
        $response->getBody()->write($result);

        return $response;
    }
}