<?php

namespace Tests\Infrastructure\Persistence\UserAccount;

use App\Domain\UserAccount\CreateUserAccount;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use Tests\TestCase;
use PDO;

class UserAccountDBRepositoryTest extends TestCase
{
    public function testCreateUserAccount(){

        // given
        $createUserAccount = new CreateUserAccount(1, 1, "nayoon", "nayoon@naver.com", "12341234");
        $userAccountDBRepository = new UserAccountDBRepository();
        // when
        $userAccount = $userAccountDBRepository->createUserAccount($createUserAccount);

        // then
        $this->assertEquals($userAccount->getName(), $createUserAccount->getName());
        $this->assertEquals($userAccount->getEmail(), $createUserAccount->getEmail());
    }
}