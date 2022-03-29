<?php

namespace App\Infrastructure\Persistence\Store;

use App\Domain\Store\Store;
use App\Exception\Store\GoodsNotExistsException;
use App\Exception\Store\StoreDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class StoreDBRepository extends BaseDBRepository
{
    public function findByStoreId($storeId) {
        $query = "select * from store where store_id = :store_id";

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(':store_id', $storeId);

            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $result = new Store($result['store_id'], $result['goods_id'], $result['goods_type_id']
                    , $result['asset_id'], $result['cost']);
            } else {
                throw new GoodsNotExistsException();
            }
            return $result;
        } catch (PDOException $e) {
            throw new StoreDBException();
        }
    }
}