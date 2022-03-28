<?php

namespace App\Service\Auction;

use App\Infrastructure\Persistence\Auction\UserFishAuctionDBException;
use App\Infrastructure\Persistence\Auction\UserFishAuctionDBRepository;

class UpdateUserFishAuctionService
{
    private UserFishAuctionDBRepository $userFishAuctionDBRepository;

    public function __construct(UserFishAuctionDBRepository $userFishAuctionDBRepository) {
        $this->userFishAuctionDBRepository = $userFishAuctionDBRepository;
    }

    public function updateAuction($userId, $gold, $sellDate) {
        try {
            if (!$this->getUserFishAuction($userId))
                $this->addUserFishAuction($userId);
            $this->userFishAuctionDBRepository->updateGold($userId, $gold, $sellDate);
        } catch(UserFishAuctionDBException $e) {
            throw $e;
        }
    }
    public function addUserFishAuction($userId) {
        try {
            $this->userFishAuctionDBRepository->insertUserFishAuction($userId);
        } catch(UserFishAuctionDBException $e) {
            throw $e;
        }
    }
    public function getUserFishAuction($userId) {
        try {
            return $this->userFishAuctionDBRepository->findByUserId($userId);
        } catch(UserFishAuctionDBException $e) {
            throw $e;
        }
    }
}