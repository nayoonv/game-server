<?php

declare(strict_types=1);

use App\Application\Actions\Inventory\ReadInvenAction;
use App\Application\Actions\UserAccount\CreateUserAccountAction;
use App\Application\Actions\UserAccount\LoginUserAccountAction;
use App\Application\Actions\Common\ViewUploadAction;
use App\Application\Actions\Common\UploadFileAction;
use App\Application\Middleware\JwtAuthentication;
use App\Application\Actions\Weather\ReadWeatherAction;
use App\Application\Actions\Fishing\AddUserFishAction;
use App\Application\Actions\Fishing\ReadUserCurrentEquipAction;
use App\Application\Actions\Arrival\UpdateUserFishBeforeCalAction;
use App\Application\Actions\Fishing\UpdateUserBoatDurabilityAction;
use App\Application\Actions\Arrival\UpdateAfterFishingAction;
use App\Application\Actions\GiftBox\ReadUserGiftBoxAction;
use App\Application\Actions\GiftBox\UpdateUserGiftBoxReceivedAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Application\Actions\Departure\UpdateUserFishingPlaceAction;

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // 파일 업로드 페이지 열기
    $app->post('/upload', UploadFileAction::class);
    // 파일 업로드 기능 - post
    $app->get('/file-upload', ViewUploadAction::class);

    // 1. 회원가입
    $app->post('/create-new-account', CreateUserAccountAction::class);

    // 2. 로그인
    $app->post('/login', LoginUserAccountAction::class);

    // 토큰없이 접근 불가
    $app->group('/auth', function (Group $group) {
        // 2. 유저 인벤토리 목록 조회
        $group->post('/read-inven', ReadInvenAction::class);
//        // 채비 변경 - 낚싯대
//        $group->post('/update-u')
        // 7. 날씨 정보 조회
        $group->post('/read-weather', ReadWeatherAction::class);

        // 목적지 결정 후 출항하기
        $group->post('/update-user-fishing-place', UpdateUserFishingPlaceAction::class);

        $group->post('/read-user-current-equip', ReadUserCurrentEquipAction::class);
        // 목적지에서 물고기 잡기(인벤토리 추가)
        $group->post('/add-user-fish', AddUserFishAction::class);

        // 보로롱24호 내구도 감소
        $group->post('/update-user-boat-durability', UpdateUserBoatDurabilityAction::class);

        $group->post('/update-after-fishing', UpdateAfterFishingAction::class);

        // 정산
        $group->post('/update-user-fish-before-cal', UpdateUserFishBeforeCalAction::class);

        // 선물함
        $group->post('/read-user-gift-box', ReadUserGiftBoxAction::class);
        $group->post('/update-user-gift-box-received', UpdateUserGiftBoxReceivedAction::class);

    })->add(new JwtAuthentication());

    $app->post('/db-test', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);
//        $userId = $request->getParsedBody()["user_id"];
        $tide = 'tide';
        $sth = $db->prepare("select * from ".$tide);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world1');
        return $response;
    });
};

