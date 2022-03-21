<?php

namespace App\Service\Book;

use App\Infrastructure\Persistence\Book\UserBookDBRepository;

class GetUserBookService
{
    private UserBookDBRepository $userBookDBRepository;

    public function __construct(UserBookDBRepository $userBookDBRepository) {
        $this->userBookDBRepository = $userBookDBRepository;
    }

    public function getUserBook($userId) {
        return $this->userBookDBRepository->findByUserId($userId);
    }
}