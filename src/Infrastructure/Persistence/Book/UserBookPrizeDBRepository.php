<?php

namespace App\Infrastructure\Persistence\Book;

use App\Exception\Book\UserBookPrizeDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserBookPrizeDBRepository extends BaseDBRepository
{
    public function findByUserId($userId) {
        $query = "select * from user_book_prize where user_id = :user_id";
        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $bookes = $sth->fetchAll();
            if ($bookes) {
                foreach($bookes as &$book) {
                    array_push($result, new UserBookPrize($book['user_id'], $book['book_prize_id'], $book['get_date']));
                }
            }
        } catch(UserBookPrizeDBException $exception) {

        }
        return $result;

    }
    public function updateBookPrizeId($userId, $bookPrizeId) {
        $query = "update user_book_prize set book_prize_id = :book_prize_id where user_id = :user_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->bindParam('book_prize_id', $bookPrizeId);
            $sth->execute();

            $this->db->commit();
        } catch(UserBookPrizeDBException $exception) {

        }
    }
}