<?php

namespace App\Service\User;

use App\Domain\User\User;
use App\Exception\Boat\NotCreateUserBoatException;
use App\Exception\Login\UserAccountUserDBException;
use App\Exception\Map\UserMapDBException;
use App\Exception\User\UserDBException;
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

    public function findUser($hiveId): User {
        try {
            $userId = $this->loginUserAccountUserService->getUser($hiveId);

            if ($userId == 0) {
                $userId = $this->createUser($hiveId);
                $this->initGameData($userId);
            }

            return $this->userDBRepository->findByUserId($userId);

        } catch (UserAccountUserDBException|UserMapDBException|NotCreateUserBoatException|UserDBException $e) {
            throw $e;
        }
    }

    public function createUser($hiveId): int {
        try {
            return $this->userDBRepository->createUser($hiveId);
        } catch (UserDBException $e) {
            throw $e;
        }
    }

    public function initGameData($userId) {
        try {
            // 기본 item inventory에 추가하기
            // user_boat 추가하기
            $this->createBoatService->createUserBoat($userId);
            // user_fishing_place에 mapId 1로 지정하기
            $this->createUserMapService->createUserMap($userId);
        } catch (NotCreateUserBoatException|UserMapDBException $e) {
            throw $e;
        }
    }
}