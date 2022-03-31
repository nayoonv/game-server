<?php

namespace App\Service\Fish;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Fish\FishDBRepository;

class GetFishService
{
    private FishDBRepository $fishDBRepository;

    public function __construct(FishDBRepository $fishDBRepository) {
        $this->fishDBRepository = $fishDBRepository;
    }

    public function getFish($fishId) {
        try {
            return $this->fishDBRepository->findByFishId($fishId);
        } catch(UrukException $exception) {
            throw $exception;
        }
    }
}