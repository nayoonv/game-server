<?php

namespace App\Infrastructure\Persistence\UserAccountUser;

use App\Infrastructure\Persistence\Base\BaseDBRepository;
use App\Infrastructure\Persistence\UserAccount\UserAccountUserDBException;

class UserAccountUserDBRepository extends BaseDBRepository
{
    public function findUserIdByHiveId($hiveId): int {
        $query = "select user_id from user_account_user where hive_id = :hive_id";

        $userId = 0;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $userId = $sth->fetch();
            if (!$userId) $userId = 0;
            else $userId = (int)$userId["user_id"];
        } catch (UserAccountUserDBException $exception) {

        }
        return $userId;
    }
}