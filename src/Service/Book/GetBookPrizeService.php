<?php

namespace App\Service\Book;

use App\Infrastructure\Persistence\Book\BookPrizeDBRepository;

class GetBookPrizeService
{
    private BookPrizeDBRepository $bookPrizeDBRepository;

    public function __construct(BookPrizeDBRepository $bookPrizeDBRepository) {
        $this->bookPrizeDBRepository = $bookPrizeDBRepository;
    }

    public function getBookPrize($bookPrizeId) {
        return $this->bookPrizeDBRepository->findByBookPrizeId($bookPrizeId);
    }

    public function getBookPrizeBetweenCount($previousCount, $currentCount) {
        return $this->bookPrizeDBRepository->findBetweenCount($previousCount + 1, $currentCount);
    }
}