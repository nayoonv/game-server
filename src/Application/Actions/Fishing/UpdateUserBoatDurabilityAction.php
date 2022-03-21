<?php

namespace App\Application\Actions\Fishing;
use App\Service\Boat\UpdateUserBoatWhileFishingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserBoatDurabilityAction
{
    private UpdateUserBoatWhileFishingService $updateUserBoatWhileFishingService;

    public function __construct(UpdateUserBoatWhileFishingService $updateUserBoatWhileFishingService) {
        $this->updateUserBoatWhileFishingService = $updateUserBoatWhileFishingService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $userBoatInfo = $this->updateUserBoatWhileFishingService->updateUserBoatDurability($userId);

        $response->getBody()->write(json_encode($userBoatInfo, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}