<?php

namespace App\Application\Actions\Inventory;

use App\Service\Inventory\ReadInvenService;

class ReadInvenAction
{
    private ReadInvenService $readInvenService;

    public function __construct(ReadInvenService $readInvenService) {
        $this->readInvenService = $readInvenService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $userId = $request->getParsedBody()['user_id'];

        $inventoryInfo = $this->readInvenService->getInvenInfo($userId);

        $response->getBody()->write($inventoryInfo);

        return $response;
    }
}