<?php

declare(strict_types=1);

use App\Application\Actions\Arrival\UpdateAfterFishingAction;
use App\Application\Actions\Arrival\UpdateUserFishBeforeCalAction;
use App\Application\Actions\Auction\AddUserFishCostAction;
use App\Application\Actions\Auction\ReadUserFishAuction;
use App\Application\Actions\Book\ReadUserBookAction;
use App\Application\Actions\Common\UploadFileAction;
use App\Application\Actions\Common\ViewUploadAction;
use App\Application\Actions\Departure\UpdateUserFishingPlaceAction;
use App\Application\Actions\Fishing\AddUserFishAction;
use App\Application\Actions\Fishing\UpdateUserBoatDurabilityAction;
use App\Application\Actions\GiftBox\ReadUserGiftBoxAction;
use App\Application\Actions\GiftBox\UpdateUserGiftBoxReceivedAction;
use App\Application\Actions\Inventory\ReadInvenAction;
use App\Application\Actions\UserAccount\CreateUserAccountAction;
use App\Application\Actions\UserAccount\LoginUserAccountAction;
use App\Application\Actions\UserEquip\ReadUserCurrentEquipAction;
use App\Application\Actions\UserEquip\UpdateUserCurrentEquipAction;
use App\Application\Actions\Weather\ReadWeatherAction;
use App\Application\Actions\Store\BuyItemAction;

use App\Application\Middleware\JwtAuthentication;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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

        // 7. 날씨 정보 조회
        $group->post('/read-weather', ReadWeatherAction::class);

        // 목적지 결정 후 출항하기
        $group->post('/update-user-fishing-place', UpdateUserFishingPlaceAction::class);

        // 기존 채비 확인
        $group->post('/read-user-current-equip', ReadUserCurrentEquipAction::class);

        // 채비 변경 - 낚싯대
        $group->post('/update-user-current-equip', UpdateUserCurrentEquipAction::class);

        // 목적지에서 물고기 잡기(인벤토리 추가)
        $group->post('/add-user-fish', AddUserFishAction::class);

        // 보로롱24호 내구도 감소
        $group->post('/update-user-boat-durability', UpdateUserBoatDurabilityAction::class);

        // 입항
        $group->post('/update-after-fishing', UpdateAfterFishingAction::class);

        // 경매 성공
        $group->post('/add-user-fish-cost', AddUserFishCostAction::class);
        $group->post('/read-user-fish-auction', ReadUserFishAuction::class);
        // 도감 보여주기
        $group->post('/read-user-book', ReadUserBookAction::class);

        // 선물함
        $group->post('/read-user-gift-box', ReadUserGiftBoxAction::class);
        $group->post('/update-user-gift-box-received', UpdateUserGiftBoxReceivedAction::class);

        $group->post('/buy-item', BuyItemAction::class);

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

