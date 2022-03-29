<?php

namespace App\Service\UserAccount;

use App\Exception\Base\UrukException;
use App\Exception\Signup\DuplicateEmailException;
use App\Exception\Signup\NoEmailInputException;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class SignUpUserAccountService
{
    private UserAccountDBRepository $userAccountDBRepository;

    public function __construct(UserAccountDBRepository $userAccountDBRepository) {
        $this->userAccountDBRepository = $userAccountDBRepository;
    }

    public function createUserAccount($createUserAccount) {
        $userEmail = $createUserAccount->getEmail();

        $result = null;
        try {
            if ($userEmail != null) {
                $hiveId = $this->userAccountDBRepository->isEmailExist($userEmail);

                if ($hiveId == 0) {
                    // 메일이 없다는 것은 계정이 없다는 것을 의미한다.
                    $hiveId = $this->userAccountDBRepository->createUserAccount($createUserAccount)->getHiveId();

                    // SuccessResponseManager를 통해 응답을 성공적으로 반환
                    $result = SuccessResponseManager::response($userEmail . "의 회원가입이 성공하였습니다.");

                    $account = $createUserAccount->jsonSerialize();
                    $account = array_merge($account, ['hive_id' => $hiveId]);

                    // 로그 서버로 전송
                    Log::write('SIGNUP', $account);
                } else {
                    throw new DuplicateEmailException();
                }
            } else {
                throw new NoEmailInputException();
            }
        } catch (UrukException $e) {
            $result = $e->response();
        }
        return $result;
    }
}