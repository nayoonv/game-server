<?php

namespace App\Service\UserAccount;

use App\Domain\User\User1;
use App\Infrastructure\Persistence\User\UserDBRepository;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use App\Service\User\LoginUserService;

class LoginUserAccountService
{
    private UserAccountDBRepository $userAccountRepository;
    private UserDBRepository $userDBRepository;
    private LoginUserService $loginUserService;

    public function __construct(UserAccountDBRepository $userAccountRepository
        , UserDBRepository                              $userDBRepository, LoginUserService $loginUserService) {
        $this->userAccountRepository = $userAccountRepository;
        $this->userDBRepository = $userDBRepository;
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

        return $user;
    }
}