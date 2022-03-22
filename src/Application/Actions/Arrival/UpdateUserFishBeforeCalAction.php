<?php

namespace App\Application\Actions\Arrival;

use App\Service\Fish\UpdateUserFishService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserFishBeforeCalAction
{
    private UpdateUserFishService $updateUserFishService;

    public function __construct(UpdateUserFishService $updateUserFishService) {
        $this->updateUserFishService = $updateUserFishService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $userId = $request->getParsedBody()['user_id'];
        $userFishList = $this->updateUserFishService->updateBeforeCal($userId);

        $response->getBody()->write(json_encode($userFishList, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}