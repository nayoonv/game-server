<?php

namespace App\Service\Book;

use App\Domain\UserGiftBox\RequestUserGiftBox;
use App\Exception\Base\UrukException;
use App\Exception\Book\BookPrizeDBException;
use App\Exception\Book\BookPrizeNotExistsException;
use App\Infrastructure\Persistence\Book\UserBookPrizeDBRepository;
use App\Service\UserGiftBox\UserGiftBoxService;

class UpdateUserBookPrizeService
{
    private GetBookPrizeService $getBookPrizeService;
    private UserBookPrizeDBRepository $userBookPrizeDBRepository;
    private UserGiftBoxService $updateUserGiftBoxService;

    public function __construct(GetBookPrizeService $getBookPrizeService
        , UserBookPrizeDBRepository                 $userBookPrizeDBRepository, UserGiftBoxService $updateUserGiftBoxService)
    {
        $this->getBookPrizeService = $getBookPrizeService;
        $this->userBookPrizeDBRepository = $userBookPrizeDBRepository;
        $this->updateUserGiftBoxService = $updateUserGiftBoxService;
    }

    public function getUserBookPrize($userId, $totalCount)
    {
        try {
            $userBookPrize = $this->userBookPrizeDBRepository->findByUserId($userId);
            $previousFishCount = 0;
            if ($userBookPrize) {

                $previousPrize = $this->getBookPrizeService->getBookPrize($userBookPrize->getBookPrizeId());

                $previousFishCount = $previousPrize->getFishCount();
            }

            if ($totalCount != $previousFishCount) {
                $availablePrize = $this->getBookPrizeService->getBookPrizeBetweenCount($previousFishCount, $totalCount);
                $count = count($availablePrize);

                if ($count!=0) {
                    // 선물함에 선물 증정하기
                    foreach ($availablePrize as &$prize) {
                        $requestUserGiftBox = new RequestUserGiftBox($userId, 1, $prize->getAssetId()
                            , $prize->getCost());

                        $this->updateUserGiftBoxService->insertUserGiftBox($requestUserGiftBox);
                    }

                    $bookPrizeId = $availablePrize[$count - 1]->getBookPrizeId();
                    $this->userBookPrizeDBRepository->updateBookPrizeId($userId, $bookPrizeId);
                    return $availablePrize;
                }
            }
            return false;
        } catch (UrukException $e) {
            throw $e;
        }
    }
}