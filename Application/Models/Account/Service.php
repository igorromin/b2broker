<?php

namespace Application\Models\Account;

use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;

class Service
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function getBalance(int $userId, ?\DateTime $from = null, ?\DateTime $to = null): int
    {
        return $this->transactionRepository->getBalance($userId, $from, $to);
    }
}
