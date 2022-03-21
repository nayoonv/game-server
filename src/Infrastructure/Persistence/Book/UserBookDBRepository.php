<?php

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\UserBook;
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
        } catch(UserBookDBException $exception) {

        }
        return $result;
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
        } catch(UserBookDBException $exception) {

        }
        return $result;
    }
}