<?php

namespace App\Application\Actions\Auction;
use App\Service\Auction\ReadUserFishAuctionService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReadUserFishAuction
{
    private ReadUserFishAuctionService $readUserFishAuctionService;

    public function __construct(ReadUserFishAuctionService $readUserFishAuctionService) {
        $this->readUserFishAuctionService = $readUserFishAuctionService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $userId = $body['user_id'];

        $auctionResult = $this->readUserFishAuctionService->readAuction($userId);

        $response->getBody()->write(json_encode($auctionResult));

        return $response;
    }
}