<?php

namespace App\Service\Book;

use App\Infrastructure\Persistence\Book\UserBookDBRepository;

class UpdateUserBookService
{
    private UserBookDBRepository $userBookDBRepository;

    public function __construct(UserBookDBRepository $userBookDBRepository) {
        $this->userBookDBRepository = $userBookDBRepository;
    }

    public function addNewFish($userId) {
        $fishList = $this->userBookDBRepository->findNewFish($userId);
    }
}