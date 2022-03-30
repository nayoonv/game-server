<?php

namespace App\Service\Fish;

use App\Exception\Base\UrukException;
use App\Exception\Book\UserBookNotExistsException;
use App\Infrastructure\Persistence\Fish\UserFishDBRepository;
use App\Service\Book\UpdateUserBookService;
use function App\Service\Arrival\count;

class UpdateUserFishService
{
    private UserFishDBRepository $userFishDBRepository;
    private UpdateUserBookService $updateUserBookService;
    private GetUserFishService $getUserFishService;

    public function __construct(UserFishDBRepository $userFishDBRepository
        , UpdateUserBookService $updateUserBookService, GetUserFishService $getUserFishService) {
        $this->userFishDBRepository = $userFishDBRepository;
        $this->updateUserBookService = $updateUserBookService;
        $this->getUserFishService = $getUserFishService;
    }
    public function addFishInUserBook($userId) {
        try {
            $userBookFishList = $this->getUserFishService->getUserFishNotInUserBook($userId);

            if ($userBookFishList != -1 && count($userBookFishList) != 0) {
                $userBookFishIdList = array();
                foreach($userBookFishList as &$fish)
                    array_push($userBookFishIdList, ['fish_id' => $fish->getFishId(), 'catch_date' => $fish->getCatchDate()]);
                $this->updateUserBookService->addFish($userId, $userBookFishIdList);
                $this->userFishDBRepository->updateBeforeCalChecked($userId);
            } else {
                return [];
            }
            return $userBookFishList;
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function deleteUserFish($userFishId)
    {
        try {
            $this->userFishDBRepository->deleteByUserFishId($userFishId);
        } catch(UrukException $e) {
            throw $e;
        }
    }

}