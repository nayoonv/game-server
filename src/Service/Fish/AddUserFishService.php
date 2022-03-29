<?php

namespace App\Service\Fish;

use App\Domain\Fishing\FishingFish;
use App\Exception\Base\UrukException;
use App\Exception\Fish\DeepDepthException;
use App\Exception\Fish\FailToCatchFishException;
use App\Exception\Fish\FishDBException;
use App\Exception\Fish\InvenInsertFishException;
use App\Exception\Fish\NotAppearFishException;
use App\Exception\Fish\NotInsertUserFishException;
use App\Exception\Fish\UserFishDBException;
use App\Infrastructure\Persistence\Fish\FishDBRepository;
use App\Infrastructure\Persistence\Fish\UserFishDBRepository;
use App\Service\Inventory\InsertInvenService;
use App\Service\Map\GetMapService;
use App\Service\UserCurrentEquip\GetUserCurrentEquipService;
use App\Service\Weather\ReadWeatherService;
use App\Util\SuccessResponseManager;

class AddUserFishService
{
    private FishDBRepository $fishDBRepository;
    private UserFishDBRepository $userFishDBRepository;
    private GetMapService $getMapService;
    private InsertInvenService $insertInventoryService;
    private GetUserCurrentEquipService $getUserCurrentEquipService;
    private ReadWeatherService $readWeatherService;

    public function __construct(FishDBRepository $fishDBRepository
        , UserFishDBRepository                   $userFishDBRepository, GetMapService $getMapService
        , InsertInvenService                     $insertInventoryService, GetUserCurrentEquipService $getUserCurrentEquipService
        , ReadWeatherService                     $readWeatherService)
    {
        $this->fishDBRepository = $fishDBRepository;
        $this->userFishDBRepository = $userFishDBRepository;
        $this->getMapService = $getMapService;
        $this->insertInventoryService = $insertInventoryService;
        $this->getUserCurrentEquipService = $getUserCurrentEquipService;
        $this->readWeatherService = $readWeatherService;
    }

    public function getUserFish($userId, $depth)
    {
        try {
            // 물고기 잡기 (조건에 따라 물고기를 잡도록 구현하려고 하였으나, 어떤 경우에서든지 물고기를 잡을 수 있도록 구현하였습니다.)
            $userFish = $this->Fishing($userId, $depth);
            // 물고기 잡아서 inven에 넣기
            $this->InsertInvenFish($userId, $userFish);

            return SuccessResponseManager::response($userFish);
        } catch (UrukException $e) {
            return $e->exceptionResult();
        }
    }

    public function InsertInvenFish($userId, $userFish)
    {
        date_default_timezone_set("Asia/Seoul");
        $datetime = date("Y-m-d H:i:s", time());

        try {
            $userFishId = $this->userFishDBRepository->insertUserFish($userId, $userFish->getFishId(), $userFish->getLength(), $userFish->getWeight(), $datetime);
            $this->insertInventoryService->insertInvenFish($userFishId, $userId, $datetime);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    /**
     * @throws NotAppearFishException
     * @throws FailToCatchFishException
     * @throws DeepDepthException|UrukException
     */
    public function Fishing($userId, $depth)
    {
        try {
            // 사용자의 장비에 대한 정보를 가지고 와야한다.
            $userCurrentEquipInfo = $this->getUserCurrentEquipService->getUserCurrentEquipInfo($userId);

            // 사용자가 나간 바다에 대한 정보
            $mapInfo = $this->getMapService->getUserFishingPlace($userId);

            if ($mapInfo->getMaxDepth() < $depth) {
                // 너무 깊이 던진 경우
                throw new DeepDepthException();
            }
            $appearance = $this->fishApperanceProbability($userId, $mapInfo, $userCurrentEquipInfo->getHook(), $depth);

            if (!$appearance) {
                // 물고기가 등장하지 않는 경우
                throw new NotAppearFishException();
            }
            $gradeInfo = $this->fishGradeProbability($mapInfo, $depth, $userCurrentEquipInfo->getBait());

            // 사용자가 내린 낚시대의 깊이
            $fish = $this->chooseFish($depth, $mapInfo, $gradeInfo);

            // 물고기들 중 한 마리를 잡는데, 낚싯대 type에 따라 연질대이면 hooking에, 경질대이면 success에 집중
            // 실패할 수 있음
            $result = $this->catchFish($fish, $userCurrentEquipInfo);

            if (!$result) {
                throw new FailToCatchFishException();
            }
            return $fish;
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function catchFish($fish, $equipInfo)
    {
        // 연질대인지, 경질대인지
        $rodInfo = $equipInfo->getRod();
        $lineInfo = $equipInfo->getLine();
        $hookInfo = $equipInfo->getHook();

        // 잡히거나 놓치거나
        $cases = 2;
        $result = 0;
        if ($rodInfo->getRodTypeId() == 1) { // 연질대
            $hookingProbability = $rodInfo->getHookingProbability();
            $hookingProbability += $lineInfo->getHookingProbability();

            $result = $this->randomFunction($hookingProbability, $cases);
        } else { // 경질대
            $successProbability = $rodInfo->getSuccessProbability();
            $successProbability += $lineInfo->getSuccessProbability();
            $successProbability += $hookInfo->getSuccessProbability();

            $result = $this->randomFunction($successProbability, $cases);
        }

//        if ($result == 1) {
//            return false;
//        }
        return true;
    }

    public function chooseFish($depth, $mapInfo, $gradeInfo)
    {
        try {
            $fishes = $this->fishDBRepository->findByMapIdAndDistance($depth, $mapInfo->getMapId(), $gradeInfo['grade']);


            $cases = count($fishes);

            $fishNum = rand(0, $cases - 1);

            $fish = $fishes[$fishNum];

            $length = rand($fish->getMaxLength() * ($gradeInfo['gradeProbability'] / 100), $fish->getMaxLength());
            $weight = rand($fish->getMaxWeight() * ($gradeInfo['gradeProbability'] / 100), $fish->getMaxWeight());

            return new FishingFish($fish->getFishId(), $fish->getFishName(), $gradeInfo['grade'], $length, $weight);
        } catch (FishDBException $e) {
            throw $e;
        }
    }

    public function fishGradeProbability($mapInfo, $depth, $baitInfo)
    {
        $gradeProbability = $baitInfo->getAdvancedAppearanceProbability();
        $deepProbability = 50;
        $gradeProbability += $deepProbability * ($depth / $mapInfo->getMaxDepth());
        $cases = 3;

        $grade = $this->randomFunction($gradeProbability, $cases);
        return ['grade' => $grade, 'gradeProbability' => $gradeProbability];
    }

    public function fishApperanceProbability($userId, $mapInfo, $hookInfo, $depth)
    {
        $appearanceProbability = 30;
        $tideProbability = 30;
        $tidePeakProbability = 10;
        $maxTidePower = 563;
        // 잡히거나 놓치거나
        $cases = 2;
        $weatherInfo = $this->readWeatherService->getWeatherInfo($userId);

        /*
         * hook의 크기를 통해 최대 50까지 확률을 높일 수 있다.
         */
        $appearanceProbability += $hookInfo->getAppearanceProbability();

        /*
         * 얕은 지역이면서 조류 세기가 심한 경우
         * 최대 30까지 확률 감소 가능
         * 최대 조류 세기: 563
         */
        $appearanceProbability -= ($tideProbability * ($weatherInfo->getTidePower() / $maxTidePower) * ($depth / $mapInfo->getMaxDepth()));

        /*
         * 물돌이 시간일 경우
         * 물돌이가 진행되는 '시'에 낚시를 할 경우 tidePeakProbability가 감소한다.
         */
//        if (date(strtotime($weatherInfo->getTideTime()), "G") == date("G")) {
//            $appearanceProbability -= $tidePeakProbability;
//        }

        if ($this->randomFunction($appearanceProbability, $cases) == 2) {
            return true;
        }
        return false;
    }

    public function randomFunction($probability, $cases)
    {
        if ($probability > 10)
            return $cases;
        else if ($probability > 50)
            return $cases - 1;
        else
            return 1;
    }
}