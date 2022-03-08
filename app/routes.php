<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\UserAccount\LoginUserAccountAction;
use App\Application\Actions\Common\ViewUploadAction;
use App\Application\Actions\Common\UploadFileAction;

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
        $tide = 'tide';
        $sth = $db->prepare("desc ".$tide);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    // 파일 업로드 페이지 열기
    $app->post('/upload', UploadFileAction::class);
    // 파일 업로드 기능 - post
    $app->get('/file-upload', ViewUploadAction::class);

    // 1. 로그인
    $app->post('/login', LoginUserAccountAction::class);

    // 2. 유저 인벤토리 목록 조회
    $app->post('/read-inven', ReadInvenAction::class);

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};

