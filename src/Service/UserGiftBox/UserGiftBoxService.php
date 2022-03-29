<?php

namespace App\Service\UserGiftBox;

use App\Exception\Base\UrukException;
use App\Exception\GiftBox\UserGiftBoxDBException;
use App\Infrastructure\Persistence\GiftBox\UserGiftBoxDBRepository;
use App\Util\SuccessResponseManager;

class UserGiftBoxService
{
    private UserGiftBoxDBRepository $userGiftBoxDBRepository;

    public function __construct(UserGiftBoxDBRepository $userGiftBoxDBRepository) {
        $this->userGiftBoxDBRepository = $userGiftBoxDBRepository;
    }

    public function insertUserGiftBox($userGiftBox) {
        try {
            $this->userGiftBoxDBRepository->insertUserGiftBox($userGiftBox);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function readUserGiftBox($userId) {
        try {
            return SuccessResponseManager::response($this->userGiftBoxDBRepository->findByUserId($userId));
        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function updateUserGiftBox($userGiftBoxId) {
        try {
        // update 도중 발생하는 문제에 대한 try - catch 문 예외 처리 필요
            $this->userGiftBoxDBRepository->updateUserGiftBox($userGiftBoxId);
            $result = "선물을수령하였습니다.";

            return SuccessResponseManager::response($result);
        } catch (UserGiftBoxDBException $e) {
            return $e->response();
        }
    }
}