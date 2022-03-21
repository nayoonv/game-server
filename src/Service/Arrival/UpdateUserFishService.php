<?php

namespace App\Service\Arrival;

use App\Infrastructure\Persistence\Fish\UserFishDBRepository;
use App\Service\Book\UpdateUserBookService;

class UpdateUserFishService
{
    private UserFishDBRepository $userFishDBRepository;
    private UpdateUserBookService $updateUserBookService;

    public function __construct(UserFishDBRepository $userFishDBRepository) {
        $this->userFishDBRepository = $userFishDBRepository;
    }
    public function updateBeforeCal($userId) {
        $userBookFishList = $this->updateUserBookService->addNewFish($userId);
        $this->userFishDBRepository->updateBeforeCalChecked($userId);
        return $userBookFishList;
    }

}