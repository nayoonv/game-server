<?php

namespace App\Service\Auction;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Auction\UserFishAuctionDBRepository;
use App\Util\SuccessResponseManager;

class ReadUserFishAuctionService
{
    private UserFishAuctionDBRepository $userFishAuctionDBRepository;

    public function __construct(UserFishAuctionDBRepository $userFishAuctionDBRepository) {
        $this->userFishAuctionDBRepository = $userFishAuctionDBRepository;
    }

    public function readAuction($userId) {
        try {
            $result = $this->userFishAuctionDBRepository->findByUserId($userId);
            return SuccessResponseManager::response($result);
        } catch(UrukException $e) {
            return $e->response();
        }
    }

    public function readAllAuction() {
        try {
            $result = $this->userFishAuctionDBRepository->findAll();
            return SuccessResponseManager::response($result);
        } catch(UrukException $e) {
            return $e->response();
        }
    }
}