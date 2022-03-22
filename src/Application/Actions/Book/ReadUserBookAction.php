<?php

namespace App\Application\Actions\Book;

use App\Service\Book\GetUserBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReadUserBookAction
{
    private GetUserBookService $getUserBookService;

    public function __construct(GetUserBookService $getUserBookService) {
        $this->getUserBookService = $getUserBookService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $result = $this->getUserBookService->getUserBookFishList($userId);

        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}