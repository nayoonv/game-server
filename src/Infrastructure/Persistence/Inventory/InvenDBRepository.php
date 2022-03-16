<?php

namespace App\Infrastructure\Persistence\Inventory;

use App\Infrastructure\Persistence\Base\BaseDBRepository;

class InvenDBRepository extends BaseDBRepository
{

    public function findInventoryFishByUserId($userId): Inventory {
        $query = "select inventory_id, inventory_type_id,  from inventory where user_id = :user_id and inventory_type_id = :inventory_type_id";

        $result = array();
        $fishNum = 1;
//        try {
//            $sth = $this->db->prepare($query);
//            $sth->bindParam(':user_id', $userId);
//            $sth->bindParam(':inventory_type_id', $fishNum);
//
//            $sth->execute();
//
//            while($sth->nextRowset()) {
//                $temp =  $sth->fetch(FETCH_ASSOC);
//
//
//
//                array_push($result, );
//            }
//
//            $result = $sth->fetch(PDO::FETCH_ASSOC);
//
//        } catch(Exception $exception) {
//
//        }

    }
}