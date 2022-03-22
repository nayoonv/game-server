<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User1;
use App\Domain\User\User1Repository;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use App\Service\User\UserDBException;

class UserDBRepository extends BaseDBRepository implements User1Repository
{
    public function findByUserId($userId): User1 {
        $query = "select level, experience, gold, pearl, fatigue from user where user_id = :user_id";

        $user = null;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

             $result = $sth->fetch();

            $user = new User1($userId, $result["level"], $result["experience"], $result["gold"]
                , $result["pearl"], $result["fatigue"]);
        } catch (UserDBException $exception) {

        }
        return $user;
    }

    public function createUser($hiveId): int {
        $query1 = "insert into user values ()";
        $query2 = "insert into user_account_user values (:hive_id, :user_id);";

        $userId = 0;
        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query1);

            $sth->execute();

            $userId = $this->db->lastInsertId();

            $sth = $this->db->prepare($query2);

            $sth->bindParam(':hive_id', $hiveId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $this->db->commit();
        } catch (UserDBException $exception) {

        }
        return $userId;
    }
}