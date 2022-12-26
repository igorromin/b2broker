<?php

declare(strict_types=1);

namespace Application\ORM;

interface RepositoryInterface
{
    public function assignTransaction(Transaction $transaction): void;
}
