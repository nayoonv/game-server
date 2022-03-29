<?php

namespace App\Infrastructure\Persistence\UserAccount;

use App\Domain\UserAccount\LoginUser;
use App\Domain\UserAccount\UserAccount;
use App\Exception\Signup\UserAccountDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserAccountDBRepository extends BaseDBRepository
{
    public function findUserAccountByHiveId($hiveId): UserAccount {
        $query = "select hive_id, nation_id, language_id, name, email from user_account where hive_id = :hive_id";
        $result = null;
        try{
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $result = $sth->fetch();

            $result = new UserAccount($result["hive_id"], $result["nation_id"]
                , $result["language_id"], $result["name"], $result["email"]);
        } catch (PDOException $exception) {
            throw new UserAccountDBException();
        }
        return $result;
    }

    public function findUserByHiveId($hiveId): LoginUser
    {
        $query = "select u.user_id, a.nation_id, a.language_id, u.level, u.experience, u.gold, u.pearl, u.fatigue
                from user_account a
                join user u
                on a.user_id = u.user_id
                where a.hive_id = :hive_id;";

        $user = null;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $result = $sth->fetch();

            $user = new LoginUser($result["user_id"], $result["nation_id"]
                , $result["language_id"], $result["level"], $result["experience"]
                , $result["gold"], $result["pearl"], $result["fatigue"]);
        } catch(PDOException $exception) {
            throw new UserAccountDBException();
        }
        return $user;
    }

    // PK인 hiveId로 접근함으로써 조회 속도를 높이고자 했습니다.
    public function validatePasswordByHiveId($hiveId, $encryptedPassword): bool {
        $query = "select password from user_account
                where hive_id = :hive_id;";
        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $password = $sth->fetch()["password"];

            if (password_verify($password, $encryptedPassword)) {
                $result = true;
            }
        } catch(PDOException $e) {
            throw new UserAccountDBException();
        }
        return $result;
    }

    /**
     * @throws UserAccountDBException
     */
    public function isEmailExist($userEmail): int {

        $query = "select hive_id 
                from user_account
                where email = :user_email;";

        $hiveId = 0;

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_email', $userEmail);

            $sth->execute();

            $hiveId = $sth->fetch();
            if (!$hiveId) $hiveId = 0;
            else $hiveId = $hiveId["hive_id"];
        } catch(PDOException $exception) {
            throw new UserAccountDBException();
        }
        return $hiveId;
    }

    public function createUserAccount($createUserAccount): UserAccount{

        $data =[
            'nation_id' => $createUserAccount->getNationId(),
            'language_id' => $createUserAccount->getLanguageId(),
            'name' => $createUserAccount->getName(),
            'email' => $createUserAccount->getEmail(),
            'password' => password_hash($createUserAccount->getPassword(), PASSWORD_BCRYPT),
            ];

        $query = "insert into user_account(nation_id, language_id, name, email, password) values (:nation_id, :language_id, :name, :email, :password);";
        $result = null;
        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->execute($data);
            $hiveId = $this->db->lastInsertId();
            $this->db->commit();

            $result = $this->findUserAccountByHiveId($hiveId);
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserAccountDBException();
        }
        return $result;
    }
}