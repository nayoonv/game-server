<?php

namespace App\Service\Book;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Book\UserBookDBRepository;

class GetUserBookService
{
    private UserBookDBRepository $userBookDBRepository;

    public function __construct(UserBookDBRepository $userBookDBRepository) {
        $this->userBookDBRepository = $userBookDBRepository;
    }

    public function getUserBookFishList($userId) {
        try {
            $userBookFishList = $this->userBookDBRepository->findFishMapByUserId($userId);

            if (!$userBookFishList)
                $userBookFishList = [];

            $result = ['user_book_fish_list' => $userBookFishList];

            return $result;
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserBook($userId) {
        try {
            return $this->userBookDBRepository->findByUserId($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}