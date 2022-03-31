<?php

namespace App\Infrastructure\Persistence\Auction;

use App\Domain\Auction\UserFishAuction;
use App\Exception\Auction\AuctionNotExistsException;
use App\Exception\Auction\UserFishAuctionDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserFishAuctionDBRepository extends BaseDBRepository
{
    public function updateGold($userId, $gold, $sellDate) {
        $query = "update user_fish_auction set gold = gold + :gold, sell_date = :sell_date where user_id = :user_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);

            $sth->bindParam('user_id', $userId);
            $sth->bindParam('gold', $gold);
            $sth->bindParam('sell_date', $sellDate);

            $sth->execute();

            $this->db->commit();

        } catch(PDOException $exception) {
            throw new UserFishAuctionDBException();
        }
    }

    public function insertUserFishAuction($userId) {
        $query = "insert into user_fish_auction values (:user_id, 0, now())";

        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $this->db->commit();

        } catch(PDOException $exception) {
            throw new UserFishAuctionDBException();
        }
    }

    /**
     * @throws UserFishAuctionDBException
     */
    public function findByUserId($userId) {
        $query = "select * from user_fish_auction where user_id = :user_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $result = $sth->fetch();

            if($result)
                $result = new UserFishAuction($result['user_id'], $result['gold'], $result['sell_date']);

            return $result;
        } catch(PDOException $exception) {
            throw new UserFishAuctionDBException();
        }
    }

    public function findAll() {
        $query = "select * from user_fish_auction order by gold desc";

        try {
            $sth = $this->db->prepare($query);

            $sth->execute();

            $auctions = $sth->fetchAll();

            if($auctions) {
                $result = array();
                foreach($auctions as &$auction) {
                 array_push($result, new UserFishAuction($auction['user_id'], $auction['gold'], $auction['sell_date']));
                }
                return $result;
            } else {
                throw new AuctionNotExistsException();
            }
        } catch(PDOException $exception) {
            throw new UserFishAuctionDBException();
        }
    }
}