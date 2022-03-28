<?php

namespace App\Application\Actions\Store;

use App\Service\Store\BuyItemService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BuyItemAction
{
    private BuyItemService $buyItemService;

    public function __construct(BuyItemService $buyItemService) {
        $this->buyItemService = $buyItemService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];
        $storeId = $body['store_id'];

        $result = $this->buyItemService->getItem($userId, $storeId);

        $response->getBody()->write(json_encode($result));

        return $response;
    }
}