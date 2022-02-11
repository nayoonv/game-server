<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world1');
        return $response;
    });

    $app->get('/db-test', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);
        $sth = $db->prepare("SELECT * FROM tasks ORDER BY task");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/upload', function (Request $request, Response $response) {
        $params = (array)$request->getParsedBody();

        $response->getBody()->write($params['data']);
        return $response;
    });

    $app->get('/hello/{name}', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world3');
        return $response;
    });
    $app->get('/bye', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world4');
        return $response;
    });
    $app->get('/hey', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world5');
        return $response;
    });
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
