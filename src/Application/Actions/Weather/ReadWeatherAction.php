<?php

namespace App\Application\Actions\Weather;

use App\Service\Weather\ReadWeatherService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReadWeatherAction
{
    private ReadWeatherService $readWeatherService;

    public function __construct(ReadWeatherService $readWeatherService) {
        $this->readWeatherService = $readWeatherService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $userId = $request->getParsedBody()['user_id'];

        $weatherInfo = $this->readWeatherService->getWeatherInfo($userId);

        $response->getBody()->write(json_encode($weatherInfo->jsonSerialize()));

        return $response;
    }

}