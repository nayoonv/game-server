<?php

namespace App\Service\Arrival;

use App\Service\Book\GetUserBookService;
use App\Service\Book\UpdateUserBookPrizeService;
use App\Service\Departure\UpdateUserFishingPlaceService;
use App\Service\Fishing\GetUserFishService;
use App\Service\Fishing\NotFishingStatusException;
use App\Service\Fishing\NotUserFishWhileFishingException;

class UpdateAfterFishingService
{
    private UpdateUserFishService $updateUserFishService;
    private UpdateUserFishingPlaceService $updateUserFishingPlaceService;
    private GetUserFishService $getUserFishService;
    private GetUserBookService $getUserBookService;
    private UpdateUserBookPrizeService $updateUserBookPrizeService;

    public function __construct(UpdateUserFishService $updateUserFishService
        , UpdateUserFishingPlaceService $updateUserFishingPlaceService, GetUserFishService $getUserFishService
        , GetUserBookService $getUserBookService, UpdateUserBookPrizeService $updateUserBookPrizeService) {
        $this->updateUserFishService = $updateUserFishService;
        $this->updateUserFishingPlaceService = $updateUserFishingPlaceService;
        $this->getUserFishService = $getUserFishService;
        $this->getUserBookService = $getUserBookService;
        $this->updateUserBookPrizeService = $updateUserBookPrizeService;
    }

    public function getResultAfterFishing($userId) {
        $result = ['code' => 1000, 'message' => '성공하였습니다.'];
        // 입항하기
        try {
            // 입항, 입항 실패 시, NotFishingStatusException 던지기
            $this->updateUserFishingPlaceService->updateFishingStatus($userId, 0);

            $fishCaughtList = $this->getUserFishService->getUserFishWhileFishing($userId);
            array_push($result, ['fish_caught_list' => $fishCaughtList]);
            if ($fishCaughtList) {
                $addedUserBookFish = $this->updateUserFishService->updateBeforeCal($userId);
                array_push($result, ['added_user_book_fish' => $addedUserBookFish]);

                $prize = $this->prizeFromUserBook($userId);
                if ($prize) {
                    array_push($result, ['prize' => $prize]);
                }
            } else {
                throw new NotUserFishWhileFishingException();
            }

        } catch (NotFishingStatusException $notFishingStatusException) {
            return $notFishingStatusException->exceptionResult();
        } catch(NotUserFishWhileFishingException $exception) {

        }
        return $result;
    }

    public function prizeFromUserBook($userId) {
        $totalCount = count($this->getUserBookService->getUserBook($userId));
        $addedBookPrize = $this->updateUserBookPrizeService->getUserBookPrize($userId, $totalCount);
        return $addedBookPrize;
//        if ($addedBookPrize) {
//            $bookPrizeId = $addedBookPrize[count($addedBookPrize) - 1]->getBookPrizeId();
//            $this->updateUserBookPrizeService->updateBookPrizeId($userId, $bookPrizeId);
//        }
    }
}