<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserDBRepository extends BaseDBRepository
{
    /**
     * @throws UserDBException
     */
    public function findByUserId($userId) {
        $query = "select level, experience, gold, pearl, fatigue from user where user_id = :user_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                return new User($userId, $result["level"], $result["experience"], $result["gold"]
                    , $result["pearl"], $result["fatigue"]);
            }
        } catch (PDOException $exception) {
            throw new UserDBException();
        }
    }

    /**
     * @throws UserDBException
     */
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
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserDBException();
        }
        return $userId;
    }

    public function updateGold($userId, $cost) {
        $query = "update user set gold = :cost where user_id = :user_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":cost", $cost);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserDBException();
        }
    }

    public function updateFatigue($userId, $cost) {
        $query = "update user set fatigue = :cost where user_id = :user_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":cost", $cost);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserDBException();
        }
    }

    public function updatePearl($userId, $cost) {
        $query = "update user set pearl = :cost where user_id = :user_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":cost", $cost);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserDBException();
        }
    }
}