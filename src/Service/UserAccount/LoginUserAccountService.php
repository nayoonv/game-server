<?php

namespace App\Service\UserAccount;

use App\Exception\Boat\NotCreateUserBoatException;
use App\Exception\Login\InvalidEmailException;
use App\Exception\Login\InvalidPasswordException;
use App\Exception\Login\UserAccountUserDBException;
use App\Exception\Map\UserMapDBException;
use App\Exception\Signup\UserAccountDBException;
use App\Exception\User\UserDBException;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
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