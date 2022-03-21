<?php

namespace App\Service\UserGiftBox;

use App\Infrastructure\Persistence\GiftBox\UserGiftBoxDBRepository;

class UserGiftBoxService
{
    private UserGiftBoxDBRepository $userGiftBoxDBRepository;

    public function __construct(UserGiftBoxDBRepository $userGiftBoxDBRepository) {
        $this->userGiftBoxDBRepository = $userGiftBoxDBRepository;
    }

    public function insertUserGiftBox($userGiftBox) {
        $this->userGiftBoxDBRepository->insertUserGiftBox($userGiftBox);
    }

    public function readUserGiftBox($userId) {
        return $this->userGiftBoxDBRepository->findByUserId($userId);
    }

    public function updateUserGiftBox($userGiftBoxId) {
        // update 도중 발생하는 문제에 대한 try - catch 문 예외 처리 필요
        $this->userGiftBoxDBRepository->updateUserGiftBox($userGiftBoxId);
    }
}