<?php

namespace App\Service\UserEquip;

use App\Exception\Base\UrukException;
use App\Exception\Equip\UserEquipDBException;
use App\Exception\Inven\InvalidEquipException;
use App\Exception\Inven\InvenDBException;
use App\Exception\Inven\ItemNotExistsException;
use App\Exception\Login\UserAccountUserDBException;
use App\Infrastructure\Persistence\UserCurrentEquip\UserCurrentEquipDBRepository;
use App\Service\Equip\GetEquipService;
use App\Service\Inventory\ReadInvenService;
use App\Service\UserAccountUser\GetUserAccountUserService;
use App\Service\UserCurrentEquip\GetUserCurrentEquipService;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class UpdateUserCurrentEquipService
{
    private GetUserCurrentEquipService $getUserCurrentEquipService;
    private ReadInvenService $readInvenService;
    private GetUserEquipService $getUserEquipService;
    private GetEquipService $getEquipService;
    private UserCurrentEquipDBRepository $userCurrentEquipDBRepository;
    private GetUserAccountUserService $getUserAccountUserService;

    public function __construct(GetUserCurrentEquipService $getUserCurrentEquipService
        , ReadInvenService $readInvenService, GetUserEquipService $getUserEquipService
        , GetEquipService $getEquipService, UserCurrentEquipDBRepository $userCurrentEquipDBRepository
        , GetUserAccountUserService $getUserAccountUserService) {
        $this->getUserCurrentEquipService = $getUserCurrentEquipService;
        $this->readInvenService = $readInvenService;
        $this->getUserEquipService = $getUserEquipService;
        $this->getEquipService = $getEquipService;
        $this->userCurrentEquipDBRepository = $userCurrentEquipDBRepository;
        $this->getUserAccountUserService = $getUserAccountUserService;
    }

    public function updateUserCurrentEquip($userId, $inventoryId) {
        try {
            $equipInfo = $this->readInvenService->getInventoryItem($inventoryId);

            if ($equipInfo->getInventoryTypeId() == 0)
                throw new InvalidEquipException();

            $userEquip = $this->getUserEquipService->getUserEquip($equipInfo->getItemId());

            $equip = $this->getEquipService->getPreparation($userEquip->getEquipId());

            $beforeEquipId = $this->getUserEquipId($equip, $userId);

            $this->updateByPreparationType($equip, $userEquip->getUserEquipId(), $userId);

            $updatedEquipId = $this->getUserEquipId($equip, $userId);

            $updatedEquip = $this->getUserCurrentEquipService->getUserCurrentEquipInfo($userId);

            $hiveId = $this->getUserAccountUserService->getHiveId($userId);

            Log::write('ITEM_CHANGE', ['hive_id' => $hiveId, 'user_id' => $userId
                , 'before_user_equip_id' => $beforeEquipId, 'current_user_equip_id' => $updatedEquipId]);

            return SuccessResponseManager::response($updatedEquip);
        } catch (UrukException $e) {
            return $e->response();
        }
    }
    public function getUserEquipId($equip, $userId) {
        try {
            $currentEquip = $this->getUserCurrentEquipService->getByUserId($userId);
            $preparationType = $equip->getPreparationTypeId();

            $currentEquipId = 0;
            switch ($preparationType) {
                case 1:
                    $currentEquipId = $currentEquip->getUserRodId();
                    break;
                case 2:
                    $currentEquipId = $currentEquip->getUserLineId();
                    break;
                case 3:
                    $currentEquipId = $currentEquip->getUserReelId();
                    break;
                case 4:
                    $currentEquipId = $currentEquip->getUserHookId();
                    break;
                case 5:
                    $currentEquipId = $currentEquip->getUserBaitId();
                    break;
                case 6:
                    $currentEquipId = $currentEquip->getUserSinkerId();
                    break;
            }
            return $currentEquipId;
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function updateByPreparationType($equip, $userEquipId, $userId) {
        try {
            $preparationType = $equip->getPreparationTypeId();

            switch ($preparationType) {
                case 1:
                    $this->userCurrentEquipDBRepository->updateRodByUserEquipId($userId, $userEquipId);
                    break;
                case 2:
                    $this->userCurrentEquipDBRepository->updateLineByUserEquipId($userId, $userEquipId);
                    break;
                case 3:
                    $this->userCurrentEquipDBRepository->updateReelByUserEquipId($userId, $userEquipId);
                    break;
                case 4:
                    $this->userCurrentEquipDBRepository->updateHookByUserEquipId($userId, $userEquipId);
                    break;
                case 5:
                    $this->userCurrentEquipDBRepository->updateBaitByUserEquipId($userId, $userEquipId);
                    break;
                case 6:
                    $this->userCurrentEquipDBRepository->updateSinkerByUserEquipId($userId, $userEquipId);
                    break;
            }
        } catch (UrukException $e) {
            throw $e;
        }
    }
}