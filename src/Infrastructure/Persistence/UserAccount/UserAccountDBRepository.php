<?php

namespace App\Infrastructure\Persistence\UserAccount;

use App\Domain\UserAccount\LoginUser;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserAccountDBRepository extends BaseDBRepository
{
    public function findUserByHiveId($hiveId): LoginUser{
        $query = "select u.user_id, a.nation_id, a.language_id, u.level, u.experience, u.gold, u.pearl, u.fatigue
                from user_account a
                join user u
                on a.user_id = u.user_id
                where a.hive_id = :hive_id;";
        $sth = $this->db->prepare($query);
        $sth->bindParam(':hive_id', $hiveId);
        $sth->execute();
        $result = $sth->fetch();

        return new LoginUser($result["user_id"], $result["nation_id"]
            , $result["language_id"], $result["level"], $result["experience"]
            , $result["gold"], $result["pearl"], $result["fatigue"]);
    }
}