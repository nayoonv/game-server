<?php

namespace App\Service\User;

use App\Domain\User\User;
use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\User\UserDBRepository;
use App\Service\Boat\CreateBoatService;
use App\Service\Map\CreateUserMapService;
use App\Service\UserAccountUser\LoginUserAccountUserService;
use App\Service\UserCurrentEquip\CreateUserCurrentEquipService;

class LoginUserService
{
    private UserDBRepository $userDBRepository;
    private CreateBoatService $createBoatService;
    private CreateUserMapService $createUserMapService;
    private CreateUserCurrentEquipService $createUserCurrentEquipService;
    private LoginUserAccountUserService $loginUserAccountUserService;

    public function __construct(UserDBRepository $userDBRepository, CreateBoatService $createBoatService
        , CreateUserMapService $createUserMapService, LoginUserAccountUserService $loginUserAccountUserService
        , CreateUserCurrentEquipService $createUserCurrentEquipService) {
        $this->userDBRepository = $userDBRepository;
        $this->createBoatService = $createBoatService;
        $this->createUserMapService = $createUserMapService;
        $this->loginUserAccountUserService = $loginUserAccountUserService;
        $this->createUserCurrentEquipService = $createUserCurrentEquipService;
    }

    // 게임 내 사용자 찾기
    public function findUser($hiveId): User {
        try {
            $userId = $this->loginUserAccountUserService->getUser($hiveId);

            if ($userId == 0) {
                $userId = $this->createUser($hiveId);
                $this->initGameData($userId);
            }

            return $this->userDBRepository->findByUserId($userId);

        } catch (UrukException $e) {
            throw $e;
        }
    }

    // 게임 내 사용자 생성
    public function createUser($hiveId): int {
        try {
            return $this->userDBRepository->createUser($hiveId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    // 게임 데이터 초기화
    // user boat 추가, 사용자 낚시 시작 지역을 map_id = 1로 설정
    public function initGameData($userId) {
        try {
            // 기본 item inventory에 추가하기
            // user_boat 추가하기
            $this->createBoatService->createUserBoat($userId);
            // user_fishing_place에 mapId 1로 지정하기
            $this->createUserMapService->createUserMap($userId);
            $this->createUserCurrentEquipService->createUserCurrentEquip($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}