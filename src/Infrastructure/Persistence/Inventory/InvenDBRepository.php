<?php

namespace App\Infrastructure\Persistence\Inventory;

use App\Domain\Inventory\InvenEquip;
use App\Domain\Inventory\InvenFish;
use App\Domain\Inventory\InvenItem;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class InvenDBRepository extends BaseDBRepository
{
    public function findInventoryFishByUserId($userId) {
        $query = "select inventory_id, inventory_type_id, u.fish_id, f.fish_name 
                from inventory i 
                join user_fish u on i.item_id = u.user_fish_id 
                join fish f on u.fish_id = f.fish_id 
                where i.user_id = :user_id and i.inventory_type_id = 0";

        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $fishes = $sth->fetchAll();

            if($fishes) {
                $result = array();
                foreach($fishes as &$fish) {
                    array_push($result, new InvenFish($fish['inventory_id']
                        , $fish['inventory_type_id'], $fish['fish_id'], $fish['fish_name']));
                }
            }

        } catch(PDOException $exception) {
            throw new InvenDBException();
        }

        return $result;
    }

    public function findInventoryEquipByUserId($userId) {
        $query = "select inventory_id, inventory_type_id, u.equip_id
                from inventory i 
                join user_equip u on i.item_id = u.user_equip_id 
                join equip e on u.equip_id = e.equip_id 
                where i.user_id = :user_id and i.inventory_type_id = 1";

        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $equips = $sth->fetchAll();

            if ($equips) {
                $result = array();
                foreach($equips as &$equip) {
                    array_push($result, new InvenEquip($equip['inventory_id'], $equip['inventory_type_id']
                        , $equip['equip_id']));
                }
            }

        } catch(Exception $exception) {
            throw new InvenDBException();
        }

        return $result;
    }

    public function insertUserFish($userFishId, $userId, $datetime) {
        $query = "insert into inventory(user_id, inventory_type_id, item_id, get_date) values (:user_id, 0, :user_fish_id, :get_date)";

        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);

            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':user_fish_id', $userFishId);
            $sth->bindParam(':get_date', $datetime);

            $sth->execute();

            $this->db->commit();

        } catch (PDOException $exception) {
            throw new InvenInsertFishException();
        }
    }

    public function findUserEquipByInventoryId($inventoryId) {
        $query = "select * from inventory where inventory_id = :inventory_id";

        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':inventory_id', $inventoryId);

            $sth->execute();

            $result = $sth->fetch();

            if($result) {
                $result = new InvenItem($result['inventory_id'], $result['user_id'], $result['item_id']
                    , $result['get_date'], $result['inventory_type_id']);
            } else  {
                throw new ItemNotExistsException();
            }
        } catch (ItemNotExistsException $e) {
            throw $e;
        } catch(PDOException $exception) {
            throw new InvenDBException();
        }

        return $result;
    }

    public function insertUserEquip($userEquipId, $userId) {
        $query = "insert into inventory(user_id, inventory_type_id, item_id) 
                values (:user_id, 1, :user_equip_id)";

        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);

            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':user_equip_id', $userEquipId);

            $sth->execute();

            $inventoryId = $this->db->lastInsertId();

            $this->db->commit();

            return $inventoryId;
        } catch (PDOException $exception) {
            throw new InvenInsertEquipException();
        }
    }
}