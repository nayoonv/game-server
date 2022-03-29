<?php

namespace App\Infrastructure\Persistence\UserAccountUser;

use App\Exception\Base\UrukException;
use App\Exception\Login\UserAccountUserDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserAccountUserDBRepository extends BaseDBRepository
{
    public function findUserIdByHiveId($hiveId): int {
        $query = "select user_id from user_account_user where hive_id = :hive_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $userId = $sth->fetch();

            if (!$userId) $userId = 0;
            else $userId = (int)$userId["user_id"];
            return $userId;

        } catch (PDOException $exception) {
            throw new UserAccountUserDBException();
        }
    }

    public function findHiveIdByUserId($userId): int {
        $query = "select hive_id from user_account_user where user_id = :user_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $hiveId = $sth->fetch();

            if (!$hiveId) throw new UserAccountUserDBException();
            else $hiveId = (int)$hiveId["hive_id"];

            return $hiveId;
        } catch (PDOException $exception) {
            throw new UserAccountUserDBException();
        } catch (UrukException $e) {
            throw $e;
        }
    }
}