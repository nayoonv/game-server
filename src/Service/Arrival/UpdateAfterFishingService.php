<?php

namespace App\Service\Arrival;

use App\Exception\Arrival\NotUserFishWhileFishingException;
use App\Exception\Base\UrukException;
use App\Exception\Book\BookPrizeDBException;
use App\Exception\Book\BookPrizeNotExistsException;
use App\Exception\Book\UserBookDBException;
use App\Exception\Fish\NotFishingStatusException;
use App\Exception\Fish\UserFishDBException;
use App\Exception\Map\UserMapDBException;
use App\Service\Book\GetUserBookService;
use App\Service\Book\UpdateUserBookPrizeService;
use App\Service\Departure\UpdateUserFishingPlaceService;
use App\Service\Fish\GetUserFishService;
use App\Service\Fish\UpdateUserFishService;
use App\Util\SuccessResponseManager;

class UpdateAfterFishingService
{
    private UpdateUserFishService $updateUserFishService;
    private UpdateUserFishingPlaceService $updateUserFishingPlaceService;
    private GetUserFishService $getUserFishService;
    private GetUserBookService $getUserBookService;
    private UpdateUserBookPrizeService $updateUserBookPrizeService;

    public function __construct(UpdateUserFishService $updateUserFishService
        , UpdateUserFishingPlaceService               $updateUserFishingPlaceService, GetUserFishService $getUserFishService
        , GetUserBookService                          $getUserBookService, UpdateUserBookPrizeService $updateUserBookPrizeService)
    {
        $this->updateUserFishService = $updateUserFishService;
        $this->updateUserFishingPlaceService = $updateUserFishingPlaceService;
        $this->getUserFishService = $getUserFishService;
        $this->getUserBookService = $getUserBookService;
        $this->updateUserBookPrizeService = $updateUserBookPrizeService;
    }

    public function getResultAfterFishing($userId)
    {
        $result = array();
        // 입항하기
        try {
            // 입항, 입항 실패 시, NotFishingStatusException 던지기
            $this->updateUserFishingPlaceService->updateFishingStatus($userId, 0);

            $fishCaughtList = $this->getUserFishService->getUserFishWhileFishing($userId);

            if ($fishCaughtList) {
                array_push($result, ['fish_caught_list' => $fishCaughtList]);

                // 도감에 등록되지 않은 물고기 list 보여주고 updatebeforecal
                // 정산하지 않은 물고기들 중 도감에 등록되지 않은 물고기가 있는지 체크하고 정산 처리해준다.
                $addedUserBookFish = $this->updateUserFishService->addFishInUserBook($userId);
                array_push($result, ['added_user_book_fish' => $addedUserBookFish]);
                
                // 도감 상금 부분
                $prize = $this->prizeFromUserBook($userId);
                if ($prize) {
                    array_push($result, ['prize' => $prize]);
                }
            } else {
                // 잡은 물고기가 한마리도 없이 입항했을 때
                throw new NotUserFishWhileFishingException();
            }

            return SuccessResponseManager::response($result);

        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function prizeFromUserBook($userId)
    {
        try {
            $totalCount = count($this->getUserBookService->getUserBook($userId));

            return $this->updateUserBookPrizeService->getUserBookPrize($userId, $totalCount);

        } catch (UrukException $e) {
            throw $e;
        }
    }
}