<?php

namespace App\Application\Actions\UserEquip;

use App\Service\UserEquip\UpdateUserCurrentEquipService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserCurrentEquipAction
{
    private UpdateUserCurrentEquipService $updateUserCurrentEquipService;

    public function __construct(UpdateUserCurrentEquipService $updateUserCurrentEquipService) {
        $this->updateUserCurrentEquipService = $updateUserCurrentEquipService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $inventoryId = $body['inventory_id'];

        $equipInfo = $this->updateUserCurrentEquipService->updateUserCurrentEquip($userId, $inventoryId);

        $response->getBody()->write(json_encode($equipInfo));

        return $response;
    }
}