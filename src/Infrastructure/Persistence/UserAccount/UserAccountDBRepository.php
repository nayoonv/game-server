<?php

namespace App\Infrastructure\Persistence\UserAccount;

use App\Domain\UserAccount\LoginUser;
use App\Domain\UserAccount\UserAccount;
use App\Exception\Base\UrukException;
use App\Exception\Signup\UserAccountDBException;
use App\Exception\Signup\UserAccountNotExistsException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserAccountDBRepository extends BaseDBRepository
{
    public function findUserAccountByHiveId($hiveId): UserAccount {
        $query = "select hive_id, nation_id, language_id, name, email from user_account where hive_id = :hive_id";
        try{
            $sth = $this->db->prepare($query);
            $sth->bindParam(':hive_id', $hiveId);

            $sth->execute();

            $result = $sth->fetch();

            if($result) {
                return new UserAccount($result["hive_id"], $result["nation_id"]
                    , $result["language_id"], $result["name"], $result["email"]);
            } else {
                throw new UserAccountNotExistsException();
            }
        } catch (PDOException $exception) {
            throw new UserAccountDBException();
        } catch (UserAccountNotExistsException $e) {
            throw $e;
        }
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
            return $result;
        } catch(PDOException $e) {
            throw new UserAccountDBException();
        }
    }

    /**
     * @throws UserAccountDBException
     */
    public function isEmailExist($userEmail): int {
        $query = "select hive_id 
                from user_account
                where email = :user_email;";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_email', $userEmail);

            $sth->execute();

            $hiveId = $sth->fetch();
            if (!$hiveId) $hiveId = 0;
            else $hiveId = $hiveId["hive_id"];

            return $hiveId;
        } catch(PDOException $exception) {
            throw new UserAccountDBException();
        }
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
        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->execute($data);
            $hiveId = $this->db->lastInsertId();
            $this->db->commit();

            $result = $this->findUserAccountByHiveId($hiveId);
            return $result;
        } catch (PDOException $exception) {
            $this->db->rollBack();
            throw new UserAccountDBException();
        } catch (UrukException $e) {
            throw $e;
        }
    }
}