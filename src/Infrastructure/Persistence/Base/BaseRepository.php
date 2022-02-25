<?php

namespace App\Infrastructure\Persistence\Base;

use PDO;

abstract class BaseRepository
{
    protected PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    protected function getDB(): PDO {
        return $this->db;
    }

}