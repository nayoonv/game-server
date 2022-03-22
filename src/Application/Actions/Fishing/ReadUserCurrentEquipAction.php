<?php

namespace App\Application\Actions\Fishing;

use App\Service\UserCurrentEquip\GetUserCurrentEquipService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReadUserCurrentEquipAction
{
    private GetUserCurrentEquipService $getUserCurrentEquipService;

    public function __construct(GetUserCurrentEquipService $getUserCurrentEquipService) {
        $this->getUserCurrentEquipService = $getUserCurrentEquipService;
    }

    public function __invoke(Request $request, Response $response) {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $fishInfo = $this->getUserCurrentEquipService->getUserCurrentEquipInfo($userId);

        $response->getBody()->write(json_encode($fishInfo));

        return $response;
    }
}