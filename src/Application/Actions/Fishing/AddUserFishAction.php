<?php

namespace App\Application\Actions\Fishing;

use App\Service\Fishing\AddUserFishService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddUserFishAction
{
    private AddUserFishService $addUserFishService;

    public function __construct(AddUserFishService $addUserFishService) {
        $this->addUserFishService = $addUserFishService;
    }

    public function __invoke(Request $request, Response $response) {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $depth = $body['depth'];

        $fishInfo = $this->addUserFishService->getUserFish($userId, $depth);

        $response->getBody()->write($fishInfo);

        return $response;
    }
}