<?php

namespace App\Service\Inventory;

use App\Infrastructure\Persistence\Inventory\InvenDBRepository;
use App\Service\Equip\GetEquipService;

class ReadInvenService
{
    private InvenDBRepository $invenDBRepository;
    private GetEquipService $getEquipService;

    public function __construct(InvenDBRepository $invenDBRepository, GetEquipService $getEquipService) {
        $this->invenDBRepository = $invenDBRepository;
        $this->getEquipService = $getEquipService;
    }

    public function getInvenInfo($userId) {
        $inventoryFishList = $this->invenDBRepository->findInventoryFishByUserId($userId);
        $inventoryEquipList = $this->getInvenEquipDetailInfo($this->invenDBRepository->findInventoryEquipByUserId($userId));

        return $this->getList($inventoryFishList, $inventoryEquipList);
    }

    public function getList($inventoryFishList, $inventoryEquipList) {
        $result = array();
        foreach($inventoryFishList as &$fish) {
            array_push($result, $fish->jsonSerialize());
        }
        foreach($inventoryEquipList as &$equip) {
            array_push($result, $equip->jsonSerialize());
        }
        return $result;
    }
    public function getInvenEquipDetailInfo($inventoryEquipList) {
        if ($inventoryEquipList == null) return array();

        $len = count($inventoryEquipList);
        for($i = 0; $i < $len; $i++) {
//            $equip = $inventoryEquipList[$i];
            $preparationId = $this->getEquipService->getPreparation($inventoryEquipList[$i]->getEquipId())->getPreparationId();
            if ($inventoryEquipList[$i]->getInventoryTypeId() == 1)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getRodName($preparationId));
            else if ($inventoryEquipList[$i]->getInventoryTypeId() == 2)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getLineName($preparationId));
            else if ($inventoryEquipList[$i]->getInventoryTypeId() == 3)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getReelName($preparationId));
            else if ($inventoryEquipList[$i]->getInventoryTypeId() == 4)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getHookName($preparationId));
            else if ($inventoryEquipList[$i]->getInventoryTypeId() == 5)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getBaitName($preparationId));
            else if ($inventoryEquipList[$i]->getInventoryTypeId() == 6)
                $inventoryEquipList[$i]->setEquipName($this->getEquipService->getSinkerName($preparationId));
        }
        return $inventoryEquipList;
    }
}