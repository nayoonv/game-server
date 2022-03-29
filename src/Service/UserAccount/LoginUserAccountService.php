<?php

namespace App\Service\UserAccount;

use App\Exception\Base\UrukException;
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
            // 올바른 이메일인지 확인
            $hiveId = $this->userAccountRepository->isEmailExist($email);
            if ($hiveId == 0) {
                throw new InvalidEmailException;
            }
            // 올바른 비밀번호인지 확인
            if ($this->userAccountRepository->validatePasswordByHiveId($hiveId, $password))
                throw new InvalidPasswordException;

            // 사용자의 게임 데이터 가지고 오기
            $user = $this->loginUserService->findUser($hiveId);

            // token 발행
            $token = JWTManager::getInstance()->getToken($user->getUserId());
            $result = [
                "user"=>$user,
                "token"=>$token
            ];
            $result = SuccessResponseManager::response($result);

            Log::write('LOGIN', ['hive_id' => $hiveId, 'user_id' => $user->getUserId()]);

            return $result;
        } catch (UrukException $e) {
            return $e->response();
        }
    }
}