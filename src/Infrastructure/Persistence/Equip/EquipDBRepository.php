<?php

namespace App\Infrastructure\Persistence\Equip;

use App\Domain\Equip\CurrentBait;
use App\Domain\Equip\CurrentHook;
use App\Domain\Equip\CurrentLine;
use App\Domain\Equip\CurrentReel;
use App\Domain\Equip\CurrentRod;
use App\Domain\Equip\CurrentSinker;
use App\Domain\Equip\Equip;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class EquipDBRepository extends BaseDBRepository
{
    public function findByEquipId($equipId) {
        $query = "select * from equip where equip_id = :equip_id";

        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':equip_id', $equipId);
            $sth->execute();
            $result = $sth->fetch();

            if($result) {
                $result = new Equip($equipId, $result['preparation_id'], $result['preparation_type_id']);
            }
        } catch (EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findRodByPreparationId($rodInfo) {
        $query = "select r.rod_name, r.rod_grade_id, r.rod_type_id, t.rod_type_name, g.rod_grade_name, l.hardness, l.hooking_probability, l.success_probability
                from rod r
                join rod_type t on r.rod_type_id = t.rod_type_id
                join rod_grade g on r.rod_grade_id = g.rod_grade_id
                join rod_level l on r.rod_id = l.rod_id
                where r.rod_id = :rod_id and l.rod_level = :level;";

        $data = [
            'rod_id' => $rodInfo->getPreparationId(),
            'level' => $rodInfo->getLevel()
        ];
        $result = false;

        try {

            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentRod($rodInfo->getEquipId(), $result['rod_name'], $result['rod_grade_id']
                    , $result['rod_grade_name'], $result['rod_type_id'], $result['rod_type_name'], $result['hardness']
                    , $result['hooking_probability'], $result['success_probability'], $rodInfo->getLevel(), $rodInfo->getDurability());
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findLineByPreparationId($lineInfo) {
        $query = "select l.line_name, l.strength, ll.hooking_probability, ll.success_probability
                from line l
                join line_level ll on l.line_id = ll.line_id
                where l.line_id = :line_id and ll.line_level = :level;";

        $data = [
            'line_id' => $lineInfo->getPreparationId(),
            'level' => $lineInfo->getLevel()
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentLine($lineInfo->getEquipId(), $result['line_name'], $result['strength']
                    , $result['hooking_probability'], $result['success_probability'], $lineInfo->getLevel());
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findReelByPreparationId($reelInfo) {
        $query = "select r.reel_name, r.reel_grade_id, g.reel_grade_name, r.reel_winding_amount
                from reel r
                join reel_level l on r.reel_id = l.reel_id
				join reel_grade g on r.reel_grade_id = g.reel_grade_id
                where r.reel_id = :reel_id and l.reel_level = :level;";

        $data = [
            'reel_id' => $reelInfo->getPreparationId(),
            'level' => $reelInfo->getLevel()
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentReel($reelInfo->getEquipId(), $result['reel_name'], $result['reel_grade_id']
                    , $result['reel_grade_name'], $result['reel_winding_amount'], $reelInfo->getLevel(), $reelInfo->getDurability());
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }
    public function findHookByPreparationId($hookInfo) {
        $query = "select hook_name, appearance_probability, success_probability
                from hook
                where hook_id = :hook_id;";

        $data = [
            'hook_id' => $hookInfo->getPreparationId()
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentHook($hookInfo->getEquipId(), $result['hook_name']
                    , $result['appearance_probability'], $result['success_probability']);
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findBaitByPreparationId($baitInfo) {
        $query = "select b.bait_name, b.bait_grade_id, g.bait_grade_name, g.advanced_appearance_probability
                from bait b
                join bait_grade g on b.bait_grade_id = g.bait_grade_id
                where b.bait_id = :bait_id;";

        $data = [
            'bait_id' => $baitInfo->getPreparationId()
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentBait($baitInfo->getEquipId(), $result['bait_name'], $result['bait_grade_id']
                    , $result['bait_grade_name'], $result['advanced_appearance_probability']);
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findSinkerByPreparationId($sinkerInfo) {
        $query = "select sinker_name, sinker_weight
                from sinker
                where sinker_id = :sinker_id;";

        $data = [
            'sinker_id' => $sinkerInfo->getPreparationId()
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch();

            if ($result) {
                $result = new CurrentSinker($sinkerInfo->getEquipId(), $result['sinker_name'], $result['sinker_weight']);
            }
        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findRodNameByPreparationId($preparationId) {
        $query = "select rod_name
                from rod
                where rod_id = :rod_id;";

        $data = [
            'rod_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['rod_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findLineNameByPreparationId($preparationId) {
        $query = "select line_name
                from line
                where line_id = :line_id;";

        $data = [
            'line_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['line_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findReelNameByPreparationId($preparationId) {
        $query = "select reel_name
                from reel
                where reel_id = :reel_id;";

        $data = [
            'reel_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['reel_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findHookNameByPreparationId($preparationId) {
        $query = "select hook_name
                from hook
                where hook_id = :hook_id;";

        $data = [
            'hook_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['hook_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }

    public function findBaitNameByPreparationId($preparationId) {
        $query = "select bait_name
                from bait
                where bait_id = :bait_id;";

        $data = [
            'bait_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['bait_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }
    public function findSinkerNameByPreparationId($preparationId) {
        $query = "select sinker_name
                from sinker
                where sinker_id = :sinker_id;";

        $data = [
            'sinker_id' => $preparationId
        ];
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $result = $sth->fetch()['sinker_name'];

        } catch(EquipNoExistsException $exception) {

        }
        return $result;
    }
}