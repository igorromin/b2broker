<?php

declare(strict_types=1);

namespace Application\Models\Account;

use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use DateTimeInterface;
use Decimal\Decimal;

final class Service
{
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function getBalance(int $userId, ?DateTimeInterface $from = null, ?DateTimeInterface $to = null): Decimal
    {
        return $this->transactionRepository->getBalance($userId, $from, $to);
    }
}
