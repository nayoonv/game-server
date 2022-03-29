<?php

namespace App\Service\Book;

use App\Exception\Base\UrukException;
use App\Exception\Book\BookPrizeDBException;
use App\Exception\Book\BookPrizeNotExistsBetweenCountException;
use App\Exception\Book\BookPrizeNotExistsException;
use App\Infrastructure\Persistence\Book\BookPrizeDBRepository;

class GetBookPrizeService
{
    private BookPrizeDBRepository $bookPrizeDBRepository;

    public function __construct(BookPrizeDBRepository $bookPrizeDBRepository) {
        $this->bookPrizeDBRepository = $bookPrizeDBRepository;
    }

    public function getBookPrize($bookPrizeId) {
        try {
            return $this->bookPrizeDBRepository->findByBookPrizeId($bookPrizeId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getBookPrizeBetweenCount($previousCount, $currentCount) {
        try {
            return $this->bookPrizeDBRepository->findBetweenCount($previousCount + 1, $currentCount);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}