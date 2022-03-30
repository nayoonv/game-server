<?php

namespace App\Application\Actions\Departure;

use App\Service\Departure\UpdateUserFishingPlaceService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserFishingPlaceAction
{
    private UpdateUserFishingPlaceService $updateUserCurrentPlaceService;

    public function __construct(UpdateUserFishingPlaceService $updateUserCurrentPlaceService) {
        $this->updateUserCurrentPlaceService = $updateUserCurrentPlaceService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $mapId = $body['map_id'];

        $mapInfo = $this->updateUserCurrentPlaceService->updateUserMap($userId, $mapId);

        $response->getBody()->write(json_encode($mapInfo));

        return $response;
    }

}

