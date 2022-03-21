<?php

namespace App\Service\Book;

use App\Domain\UserGiftBox\RequestUserGiftBox;
use App\Infrastructure\Persistence\Book\UserBookPrizeDBRepository;
use App\Service\UserGiftBox\UserGiftBoxService;

class UpdateUserBookPrizeService
{
    private GetBookPrizeService $getBookPrizeService;
    private UserBookPrizeDBRepository $userBookPrizeDBRepository;
    private UserGiftBoxService $updateUserGiftBoxService;

    public function __construct(GetBookPrizeService $getBookPrizeService
        , UserBookPrizeDBRepository                 $userBookPrizeDBRepository, UserGiftBoxService $updateUserGiftBoxService) {
        $this->getBookPrizeService = $getBookPrizeService;
    }

    public function getUserBookPrize($userId, $totalCount) {
        $userBookPrize = $this->userBookPrizeDBRepository->findByUserId($userId);
        $previousFishCount = 0;
        if ($userBookPrize) {
            $previousPrize = $this->getBookPrizeService->getBookPrize($userBookPrize->getBookPrizeId());
            $previousFishCount = $previousPrize->getFishCount();
        }

        if ($totalCount != $previousFishCount) {
            $availablePrize = $this->getBookPrizeService->getBookPrizeBetweenCount($previousFishCount, $totalCount);
            if ($availablePrize) {
                // 선물함에 선물 증정하기
                foreach($availablePrize as &$prize) {
                    $requestUserGiftBox = new RequestUserGiftBox($userId, 1, $prize->getAssetId()
                        , $prize->getCost());

                    $this->updateUserGiftBoxService->insertUserGiftBox($requestUserGiftBox);
                }

                $bookPrizeId = $availablePrize[count($availablePrize) - 1]->getBookPrizeId();
                $this->userBookPrizeDBRepository->updateBookPrizeId($userId, $bookPrizeId);
                return $availablePrize;
            }
        }
        return false;
    }
}