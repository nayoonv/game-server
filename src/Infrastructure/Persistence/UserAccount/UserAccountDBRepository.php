<?php

namespace App\Infrastructure\Persistence\UserAccount;

use App\Domain\UserAccount\LoginUser;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;
use PHPUnit\TextUI\XmlConfiguration\Logging\Logging;

class UserAccountDBRepository extends BaseDBRepository
{
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
            Logging::Log($exception);
        }
        return $user;
    }

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
            Logging::Log($exception);
        }

        return $hiveId;
    }

    public function createUserAccount($createUserAccount) {

        $data =[
            'nation_id' => $createUserAccount->getNationId(),
            'language_id' => $createUserAccount->getLanguageId(),
            'name' => $createUserAccount->getName(),
            'email' => $createUserAccount->getEmail(),
            'password' => password_hash($createUserAccount->getPassword(), PASSWORD_BCRYPT),
            ];

        $query = "insert into user_account(nation_id, language_id, name, email, password) values (:nation_id, :language_id, :name, :email, :password);";

        try {
            $sth = $this->db->prepare($query);
            $sth->execute($data);
        } catch (PDOException $exception) {
            Logging::Log($exception);
        }
    }
}