<?php

namespace App\Infrastructure\Persistence\Common;

use App\Infrastructure\Persistence\Base\BaseDBRepository;

class CommonDBRepository extends BaseDBRepository
{
    public function loadData($directory, $tableName) {
        $query = "load data local infile '$directory' ignore into table $tableName
                   fields terminated by ',' lines terminated by '\n' ignore 1 lines;";
        $sth = $this->db->prepare($query);

        $sth->execute();
    }
}

