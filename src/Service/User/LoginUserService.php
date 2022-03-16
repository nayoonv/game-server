<?php

namespace App\Service\User;

use App\Domain\User\User1;
use App\Infrastructure\Persistence\User\UserDBRepository;
use App\Service\Boat\CreateBoatService;
use App\Service\Map\CreateUserMapService;
use App\Service\UserAccountUser\LoginUserAccountUserService;

class LoginUserService
{
    private UserDBRepository $userDBRepository;
    private CreateBoatService $createBoatService;
    private CreateUserMapService $createUserMapService;
    private LoginUserAccountUserService $loginUserAccountUserService;
    public function __construct(UserDBRepository $userDBRepository, CreateBoatService $createBoatService
        , CreateUserMapService $createUserMapService, LoginUserAccountUserService $loginUserAccountUserService) {
        $this->userDBRepository = $userDBRepository;
        $this->createBoatService = $createBoatService;
        $this->createUserMapService = $createUserMapService;
        $this->loginUserAccountUserService = $loginUserAccountUserService;
    }

    public function findUser($hiveId): User1 {
        $userId = $this->loginUserAccountUserService->getUser($hiveId);
        $user = null;
        if ($userId == 0) {
            $userId = $this->createUser($hiveId);
            $this->initGameData($userId);
        }
        $user = $this->userDBRepository->findByUserId($userId);

        return $user;
    }

    public function createUser($hiveId): int {
        return $this->userDBRepository->createUser($hiveId);
    }

    public function initGameData($userId) {
        // 기본 item inventory에 추가하기
        // user_boat 추가하기
        $this->createBoatService->createUserBoat($userId);
        // user_fishing_place에 mapId 1로 지정하기
        $this->createUserMapService->createUserMap($userId);
    }
}