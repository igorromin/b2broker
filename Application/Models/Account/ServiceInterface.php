<?php

declare(strict_types=1);

namespace Application\Models\Account;

use DateTimeInterface;
use Decimal\Decimal;

interface ServiceInterface
{
    public function getBalance(
        int $accountId,
        ?DateTimeInterface $from = null,
        ?DateTimeInterface $to = null
    ): Decimal;
}
