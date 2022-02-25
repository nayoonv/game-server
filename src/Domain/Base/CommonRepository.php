<?php

namespace App\Domain\Base;

class CommonRepository extends BaseRepository
{
    public function loadData($directory, $tableName) {
        $sth = $this->db->prepare("load data local infile '$directory' ignore into table $tableName
                   fields terminated by ',' lines terminated by '\n' ignore 1 lines;");
        $sth->execute();
    }
}