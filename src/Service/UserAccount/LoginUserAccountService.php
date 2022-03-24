<?php

namespace App\Service\UserAccount;

use App\Domain\User\User1;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use App\Service\User\LoginUserService;
use App\Util\Log;

class LoginUserAccountService
{
    private UserAccountDBRepository $userAccountRepository;
    private LoginUserService $loginUserService;

    public function __construct(UserAccountDBRepository $userAccountRepository, LoginUserService $loginUserService) {
        $this->userAccountRepository = $userAccountRepository;
        $this->loginUserService = $loginUserService;
    }

    public function login($email, $password): User1 {
        $hiveId = $this->userAccountRepository->isEmailExist($email);
        if ($hiveId == 0) {
            throw new InvalidEmailException;
        }
        if ($this->userAccountRepository->validatePasswordByHiveId($hiveId, $password))
            throw new InvalidPasswordException;

        $user = $this->loginUserService->findUser($hiveId);
        Log::write('LOGIN', ['hive_id' => $hiveId, 'user_id' => $user->getUserId()]);
        return $user;
    }
}