<?php

namespace App\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserBookPrizeDBRepository extends BaseDBRepository
{
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