<?php

namespace App\Service\Cost;

use App\Exception\Base\UrukException;
use App\Exception\Fish\InvalidUserFishException;
use App\Infrastructure\Persistence\Cost\UserFishCostDBRepository;
use App\Service\Auction\UpdateUserFishAuctionService;
use App\Service\Fish\GetFishService;
use App\Service\Fish\GetUserFishService;
use App\Service\Fish\UpdateUserFishService;
use App\Service\User\UpdateUserService;
use App\Util\SuccessResponseManager;

class AddUserFishCostService
{
    private GetUserFishService $getUserFishService;
    private GetFishService $getFishService;
    private UpdateUserFishAuctionService $updateUserFishAuctionService;
    private UserFishCostDBRepository $userFishCostDBRepository;
    private UpdateUserFishService $updateUserFishService;
    private UpdateUserService $updateUserService;

    public function __construct(GetUserFishService $getUserFishService
        , UpdateUserFishAuctionService $updateUserFishAuctionService, UserFishCostDBRepository $userFishCostDBRepository
        , UpdateUserFishService $updateUserFishService, GetFishService $getFishService
        , UpdateUserService $updateUserService) {
        $this->getUserFishService = $getUserFishService;
        $this->updateUserFishAuctionService = $updateUserFishAuctionService;
        $this->userFishCostDBRepository = $userFishCostDBRepository;
        $this->updateUserFishService = $updateUserFishService;
        $this->getFishService = $getFishService;
        $this->updateUserService = $updateUserService;
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
            $this->updateUserService->updateUserAsset($userId, 1, $gold);

            // 물고기 삭제
            $this->updateUserFishService->deleteUserFish($userFishId);

            $result = array_merge(['fish_price' => $gold], ['fish_information' => $userFishInfo]);
            return SuccessResponseManager::response($result);
        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function fishPrice($userFishInfo) {
        $fishInfo = $this->getFishService->getFish($userFishInfo->getFishId());

        $maxPrice = $fishInfo->getPrice();
        $minPrice = $maxPrice;
        // 최대 가격에서 유저가 잡은 물고기의 크기와 길이, 등급에 따라 최소 가격을 정한다.
        $minPrice *= ($userFishInfo->getWeight()/$fishInfo->getMaxWeight())
                                        * ($userFishInfo->getLength()/$fishInfo->getMaxLength());
        $minPrice *= ($fishInfo->getFishGradeId()/3);

        $price = (int) rand($minPrice, $maxPrice);
        return $price;
    }
}