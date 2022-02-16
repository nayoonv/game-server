<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\File\UploadFileAction;
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
        $sth = $db->prepare("SELECT * FROM tide");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/upload', function (Request $request, Response $response) {
        $container = $app->getContainer();
        $container['upload_directory'] = require __DIR__ . '/uploads';
        $directory = $this->get('upload_directory');

        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['file'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
    });

    $app->get('/file-upload', UploadFileAction::class);

    $app->post('/bye', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world42');
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

function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}