<?php

namespace App\Application\Actions\UserAccount;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\UserAccount\UserAccountDBRepository;
use Psr\Log\LoggerInterface;

abstract class UserAccountAction extends Action
{
    protected UserAccountDBRepository $userAccountRepository;

    public function __construct(LoggerInterface $logger, UserAccountDBRepository $userAccountRepository) {
        parent::__construct($logger);
        $this->userAccountRepository = $userAccountRepository;
    }
}