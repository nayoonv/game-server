<?php

namespace App\Service\Cost;

use App\Infrastructure\Persistence\Cost\UserFishCostDBRepository;
use App\Infrastructure\Persistence\Fish\UserFishDBException;
use App\Service\Auction\UpdateUserFishAuctionService;
use App\Service\Auction\UserFishAuctionDBException;
use App\Service\Fish\GetUserFishService;
use App\Service\Fish\UpdateUserFishService;
use App\Util\SuccessResponseManager;

class AddUserFishCostService
{
    private GetUserFishService $getUserFishService;
    private UpdateUserFishAuctionService $updateUserFishAuctionService;
    private UserFishCostDBRepository $userFishCostDBRepository;
    private UpdateUserFishService $updateUserFishService;

    public function __construct(GetUserFishService $getUserFishService
        , UpdateUserFishAuctionService $updateUserFishAuctionService, UserFishCostDBRepository $userFishCostDBRepository
        , UpdateUserFishService $updateUserFishService) {
        $this->getUserFishService = $getUserFishService;
        $this->updateUserFishAuctionService = $updateUserFishAuctionService;
        $this->userFishCostDBRepository = $userFishCostDBRepository;
        $this->updateUserFishService = $updateUserFishService;
    }

    public function sellFish($userId, $userFishId) {
        try {
            // 경매하고자 하는 물고기 정보 확인
            $userFishInfo = $this->getUserFishService->getUserFish($userFishId);

            if (!$userFishInfo)
                throw new InvalidUserFishException();

            // 가격 책정
            $gold = $this->fishPrice($userFishInfo);

            /*
             * 책정된 가격에 물고기 판매
             * 물고기 가격을 기존 주간 판매 기록에 업데이트
             * 물고기 삭제
             */

            date_default_timezone_set("Asia/Seoul");
            $sellDate = date("Y-m-d H:i:s", time());

            // 판매기록 업데이트
            $this->updateUserFishAuctionService->updateAuction($userId, $gold, $sellDate);

            // 판매가 user fish cost 에 insert
            $this->userFishCostDBRepository->insertCost($userId, $userFishInfo, $gold, $sellDate);

            // 물고기 삭제
            $this->updateUserFishService->deleteUserFish($userFishId);
            return SuccessResponseManager::response($userFishInfo);
        } catch (UserFishDBException $e) {
            return $e->response();
        } catch (InvalidUserFishException $e) {
            return $e->response();
        } catch(UserFishAuctionDBException $e) {
            return $e->response();
        } catch(UserFishCostDBException $e) {
            return $e->response();
        }
    }

    public function fishPrice($userFishInfo) {
        return 10000;
    }
}