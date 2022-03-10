<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;

class LoginUserAccountService
{
    private UserAccountDBRepository $userAccountRepository;
    private CheckIfAlreadyLoginService $checkIfAlreadyLoginService;

    public function __construct(UserAccountDBRepository $userAccountRepository, CheckIfAlreadyLoginService $checkIfAlreadyLoginService) {
        $this->userAccountRepository = $userAccountRepository;
        $this->checkIfAlreadyLoginService = $checkIfAlreadyLoginService;
    }

    public function getUserInfo($hiveId) {
        // hive server에 요청한다.
        // hive server는 hive id와 session key를 redis에 저장한 후, 리턴값으로 session key를 건넨다.
        // hive server가 존재한다는 조건 하에, hive_id가 오면 user id로 session key가 있는지 찾아본다.

        // 건네진 session key로 redis를 조회한 후 일치하면 user id와 session key를 저장한다

        $user = $this->userAccountRepository->findUserByHiveId($hiveId);
        $userId = $user->getUserId();
//        if ($this->checkIfAlreadyLoginService->isExists($userId)){
//
//        }
        return $this->checkIfAlreadyLoginService->isExists($userId);
    }
}