<?php

namespace App\Infrastructure\Persistence\GiftBox;

use App\Domain\UserGiftBox\UserGiftBox;
use App\Exception\GiftBox\UserGiftBoxDBException;
use PDOException;

class UserGiftBoxDBRepository
{
    public function insertUserGiftBox($userGiftBox) {
        $query = "insert into user_gift_box(user_id, gift_type_id, gift_id, count) values (:use_id, :gift_type_id, :gift_id, :count)";
        $data = [
            'user_id' => $userGiftBox->getUserId(),
            'gift_type_id' => $userGiftBox->getGiftTypeId(),
            'gift_id' => $userGiftBox->getGiftId(),
            'count' => $userGiftBox->getCount()
        ];

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->execute($data);

            $this->db->commit();
        } catch(PDOException $exception) {
            throw new UserGiftBoxDBException();
        }
    }

    public function findByUserId($userId) {
        $query = "select * from user_gift_box where user_id = :user_id";

        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $boxes = $sth->fetchAll;
        if($boxes) {
            foreach($boxes as &$box) {
                array_push($result, new UserGiftBox($box['user_gift_box_id'], $box['user_id']
                    , $box['gift_type_id'], $box['gift_id'], $box['count'], $box['received_date'], $box['received']));
            }
        }
        } catch(PDOException $exception) {
            throw new UserGiftBoxDBException();
        }
        return $result;
    }

    public function updateUserGiftBox($userGiftBoxId) {
        $query = "update user_gift_box set received = 1 where user_gift_box_id = :user_gift_box_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_gift_box_id', $userGiftBoxId);
            $sth->execute();

            $this->db->commit();
        }  catch(PDOException $exception) {
            throw new UserGiftBoxDBException();
        }
    }

}