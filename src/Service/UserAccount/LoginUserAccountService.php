<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\Map\UserMapDBException;
use App\Infrastructure\Persistence\User\UserDBException;
use App\Infrastructure\Persistence\UserAccount\InvalidPasswordException;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBException;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBException;
use App\Service\Boat\NotCreateUserBoatException;
use App\Service\User\LoginUserService;
use App\Util\JWTManager;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class LoginUserAccountService
{
    private UserAccountDBRepository $userAccountRepository;
    private LoginUserService $loginUserService;

    public function __construct(UserAccountDBRepository $userAccountRepository, LoginUserService $loginUserService) {
        $this->userAccountRepository = $userAccountRepository;
        $this->loginUserService = $loginUserService;
    }

    public function login($email, $password) {
        try {
            $hiveId = $this->userAccountRepository->isEmailExist($email);
            if ($hiveId == 0) {
                throw new InvalidEmailException;
            }
            if ($this->userAccountRepository->validatePasswordByHiveId($hiveId, $password))
                throw new InvalidPasswordException;

            $user = $this->loginUserService->findUser($hiveId);

            $token = JWTManager::getInstance()->getToken($user->getUserId());
            $result = [
                "user"=>$user,
                "token"=>$token
            ];
            $result = SuccessResponseManager::response($result);

            Log::write('LOGIN', ['hive_id' => $hiveId, 'user_id' => $user->getUserId()]);

            return $result;
        } catch (InvalidEmailException|InvalidPasswordException|UserAccountUserDBException|UserMapDBException
                    |NotCreateUserBoatException|UserDBException|UserAccountDBException $e) {
            return $e->response();
        }
    }
}