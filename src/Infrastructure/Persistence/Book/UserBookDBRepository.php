<?php

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\UserBook;
use App\Domain\Book\UserBookWithMapInfo;
use App\Exception\Book\UserBookDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserBookDBRepository extends BaseDBRepository
{
    public function findNewFish($userId) {
        $query = "select * from user_book b where b.user_id = :user_id 
                            and fish_id not in (select f.fish_id from user_fish f where f.user_id = :user_id and before_cal = 1)";
        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $books = $sth->fetchAll();
            if ($books) {
                foreach($books as &$book) {
                    array_push($result, new UserBook($book['user_id'], $book['fish_id'], $book['catch_date']));
                }
            }
        } catch(Exception $exception) {
            throw new UserBookDBException();
        }
        return $result;
    }

    public function insertFish($userId, $fish) {
        $query = "insert into user_book values (:user_id, :fish_id, :catch_date)";
        $data = array_merge(['user_id' => $userId], $fish);
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->execute($data);
            $this->db->commit();
        } catch(Exception $exception) {
            throw new UserBookDBException();
        }
    }

    public function findByUserId($userId) {
        $query = "select * from user_book b where b.user_id = :user_id)";

        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $books = $sth->fetchAll();
            if ($books) {
                foreach($books as &$book) {
                    array_push($result, new UserBook($book['user_id'], $book['fish_id'], $book['catch_date']));
                }
            }
        } catch(Exception $exception) {
            throw new UserBookDBException();
        }
        return $result;
    }

    public function findFishMapByUserId($userId) {
        $query = "select f.fish_id, f.fish_name, f.max_length, f.max_weight, m.map_id, m.map_name 
                from user_book b 
                join fish f on b.fish_id = f.fish_id 
                join map m on f.map_id = m.map_id
                where b.user_id = :user_id;";

        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $books = $sth->fetchAll();
            if ($books) {
                foreach($books as &$book) {
                    array_push($result, new UserBookWithMapInfo($book['fish_id'], $book['fish_name']
                        , $book['map_id'], $book['map_name'], $book['max_length'], $book['max_weight']));
                }
            }
        } catch(Exception $exception) {
            throw new UserBookDBException();
        }
        return $result;
    }
}