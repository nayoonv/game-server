<?php

namespace App\Application\Actions\Auction;

use App\Service\Cost\AddUserFishCostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddUserFishCostAction
{
    private AddUserFishCostService $addUserFishCostService;

    public function __construct(AddUserFishCostService $addUserFishCostService)
    {
        $this->addUserFishCostService = $addUserFishCostService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $userFishId = $body['user_fish_id'];

        $result = $this->addUserFishCostService->sellFish($userId, $userFishId);

        $response->getBody()->write(json_encode($result));

        return $response;
    }
}