<?php

namespace App\Service\Book;

use App\Infrastructure\Persistence\Book\BookPrizeDBException;
use App\Infrastructure\Persistence\Book\BookPrizeDBRepository;
use App\Infrastructure\Persistence\Book\BookPrizeNotExistsException;

class GetBookPrizeService
{
    private BookPrizeDBRepository $bookPrizeDBRepository;

    public function __construct(BookPrizeDBRepository $bookPrizeDBRepository) {
        $this->bookPrizeDBRepository = $bookPrizeDBRepository;
    }

    public function getBookPrize($bookPrizeId) {
        try {
            return $this->bookPrizeDBRepository->findByBookPrizeId($bookPrizeId);
        } catch (BookPrizeDBException|BookPrizeNotExistsException $e) {
            throw $e;
        }
    }

    public function getBookPrizeBetweenCount($previousCount, $currentCount) {
        return $this->bookPrizeDBRepository->findBetweenCount($previousCount + 1, $currentCount);
    }
}