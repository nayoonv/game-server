<?php

namespace App\Domain\Common;

class CommonRepository
{
    public function loadData(string $directory, string $tablename) {
        // connecting db
        $db = $this->get(PDO::class);
        $sth = $db->prepare("load data local infile '$directory' ignore into table $tablename
                   fields terminated by ',' lines terminated by '\n' ignore 1 lines;");
        $sth->execute();
    }
}