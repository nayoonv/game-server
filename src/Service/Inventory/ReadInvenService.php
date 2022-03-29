<?php

namespace App\Service\Inventory;

use App\Exception\Base\UrukException;

use App\Infrastructure\Persistence\Inventory\InvenDBRepository;
use App\Service\Equip\GetEquipService;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class ReadInvenService
{
    private InvenDBRepository $invenDBRepository;
    private GetEquipService $getEquipService;

    public function __construct(InvenDBRepository $invenDBRepository, GetEquipService $getEquipService) {
        $this->invenDBRepository = $invenDBRepository;
        $this->getEquipService = $getEquipService;
    }

    public function getInvenInfo($userId) {
        try {
            $inventoryFishList = $this->invenDBRepository->findInventoryFishByUserId($userId);
            $inventoryEquipList = $this->getInvenEquipDetailInfo($this->invenDBRepository->findInventoryEquipByUserId($userId));

            Log::create_scribe_client('READ-INVEN', $userId." 인벤토리 열어보기 성공");
            return SuccessResponseManager::response($this->getList($inventoryFishList, $inventoryEquipList));
        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function getList($inventoryFishList, $inventoryEquipList) {
        $result = array();
        foreach($inventoryFishList as &$fish) {
            array_push($result, $fish);
        }
        foreach($inventoryEquipList as &$equip) {
            array_push($result, $equip);
        }
        return $result;
    }
    public function getInvenEquipDetailInfo($inventoryEquipList) {
        if ($inventoryEquipList == null) return array();

        $len = count($inventoryEquipList);
        for($i = 0; $i < $len; $i++) {
            $preparation = $this->getEquipService->getPreparation($inventoryEquipList[$i]->getEquipId());
            $preparationId = $preparation->getPreparationId();
            $preparationType = $preparation->getPreparationTypeId();
            switch($preparationType) {
                case 1:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getRodName($preparationId));
                    break;
                case 2:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getLineName($preparationId));
                    break;
                case 3:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getReelName($preparationId));
                    break;
                case 4:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getHookName($preparationId));
                    break;
                case 5:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getBaitName($preparationId));
                    break;
                case 6:
                    $inventoryEquipList[$i]->setEquipName($this->getEquipService->getSinkerName($preparationId));
                    break;
            }
        }
        return $inventoryEquipList;
    }
    public function getInventoryItem($inventoryId)  {
        try {
            return $this->invenDBRepository->findUserEquipByInventoryId($inventoryId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}