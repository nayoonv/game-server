<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class SignUpUserAccountService
{
    private UserAccountDBRepository $userAccountDBRepository;

    public function __construct(UserAccountDBRepository $userAccountDBRepository) {
        $this->userAccountDBRepository = $userAccountDBRepository;
    }

    public function createUserAccount($createUserAccount): string {
        $userEmail = $createUserAccount->getEmail();

        $result = null;

        if ($userEmail != null) {
            $hiveId = $this->userAccountDBRepository->isEmailExist($userEmail);

            if ($hiveId == 0) {
                // 메일이 없다는 것은 계정이 없다는 것을 의미한다.
                $hiveId = $this->userAccountDBRepository->createUserAccount($createUserAccount);
                $result = SuccessResponseManager::response($userEmail."의 회원가입이 성공하였습니다.");
                $account = $createUserAccount->jsonSerialize();
                array_push($account, ['hive_id' => $hiveId]);
                Log::write('SIGNUP', $account);
            } else {
                // 중복 계정이 존재하기 때문에 해당 계정으로 login하라고 return
                $result = "해당 이메일은 Hive에 가입한 이력이 존재합니다.";
            }
        } else {
            $result = "이메일을 입력해주십시오.";
        }

        return $result;
    }
}