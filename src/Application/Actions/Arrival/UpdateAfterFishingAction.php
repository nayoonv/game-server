<?php

namespace App\Application\Actions\Arrival;

use App\Service\Arrival\UpdateAfterFishingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateAfterFishingAction
{
    private UpdateAfterFishingService $updateAfterFishingService;

    public function __construct(UpdateAfterFishingService $updateAfterFishingService) {
        $this->updateAfterFishingService = $updateAfterFishingService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $result = $this->updateAfterFishingService->getResultAfterFishing($userId);

        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}