<?php

namespace App\Service\Store;

use App\Exception\Login\UserAccountUserDBException;
use App\Exception\Store\GoodsNotExistsException;
use App\Exception\Store\InvenInsertEquipException;
use App\Exception\Store\StoreDBException;
use App\Exception\Store\UserAssetNotEnoughException;
use App\Exception\Store\UserEquipInsertException;
use App\Exception\User\UserDBException;
use App\Infrastructure\Persistence\Store\StoreDBRepository;
use App\Service\Inventory\InsertInvenService;
use App\Service\User\GetUserService;
use App\Service\User\UpdateUserService;
use App\Service\UserAccountUser\GetUserAccountUserService;
use App\Service\UserEquip\AddUserEquipService;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class BuyItemService
{
    private StoreDBRepository $storeDBRepository;
    private GetUserService $getUserService;
    private AddUserEquipService $addUserEquipService;
    private InsertInvenService $insertInvenService;
    private UpdateUserService $updateUserService;
    private GetUserAccountUserService $getUserAccountUserService;

    public function __construct(StoreDBRepository $storeDBRepository, GetUserService $getUserService
        , AddUserEquipService $addUserEquipService, InsertInvenService $insertInvenService
        , UpdateUserService $updateUserService, GetUserAccountUserService $getUserAccountUserService) {
        $this->storeDBRepository = $storeDBRepository;
        $this->getUserService = $getUserService;
        $this->addUserEquipService = $addUserEquipService;
        $this->insertInvenService = $insertInvenService;
        $this->updateUserService = $updateUserService;
        $this->getUserAccountUserService = $getUserAccountUserService;
    }

    public function getItem($userId, $storeId) {
        try {
            // 물건에 대한 정보를 가지고 온다.
            $storeInfo = $this->storeDBRepository->findByStoreId($storeId);
            // 사용자에 대한 정보를 가지고 온다.
            $userInfo = $this->getUserService->getUser($userId);

            // 물건 가격과 사용자가 가지고 있는 가격을 비교한다.
            $assetType = $storeInfo->getGoodsId();
            $userAsset = false;
            $asset = $storeInfo->getCost();
            if ($assetType === 1) { // 골드
                $userAsset = $userInfo->getGold();
            } else if ($assetType === 3) {
                $userAsset = $userInfo->getPearl();
            }

            // 사용자가 가지고 있는 돈이 더 많으면 user_equip에 추가하고 inventory에도 추가한다.
            if ($userAsset >= $asset) {
                $cost = $userAsset - $asset;
                // user_equip에 추가
                $equipType = $storeInfo->getGoodsTypeId(); // preparation_type_id
                $equipId = $storeInfo->getGoodsId(); // equip_id
                $userEquipId = false;
                if ($equipType <= 3) { // upgrade 가능 아이템들
                    $level = 1;
                    $userEquipId = $this->addUserEquipService->addEquipUpgradeAvailable($userId, $equipId, $level, $equipType);
                } else {
                    $userEquipId = $this->addUserEquipService->addEquipUpgradeUnavailable($userId, $equipId);
                }

                // inventory에 추가
                if ($userEquipId) {
                    // inventory에 추가하기
                    $inventoryId = $this->insertInvenService->insertInvenEquip($userEquipId, $userId);

                    // 사용자한테서 돈 빼기
                    $this->updateUserService->updateUserAsset($userId, $assetType, $cost);

                    $hiveId = $this->getUserAccountUserService->getHiveId($userId);
                    $log = ["hive_id" => $hiveId, "user_id" => $userId, "goods_id" => $equipId, "asset_id" => $assetType, "cost" => $asset];
                    Log::write("ASSET", $log);

                    $result = ["asset_type" => $assetType, "left_asset" => $cost, "inventory_id" => $inventoryId];

                    return SuccessResponseManager::response($result);
                } else {
                    throw new UserEquipInsertException();
                }

            } else {
                throw new UserAssetNotEnoughException();
            }
            // 그렇지 않으면 Exception을 출력한다.
        } catch (StoreDBException|GoodsNotExistsException|UserAssetNotEnoughException|InvenInsertEquipException
        |UserDBException|UserAccountUserDBException|UserEquipInsertException $e) {
            return $e->response();
        }
    }
}