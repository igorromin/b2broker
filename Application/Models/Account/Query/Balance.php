<?php

declare(strict_types=1);

namespace Application\Models\Account\Query;

use Application\Models\Account\ServiceInterface;
use DateTimeInterface;
use Decimal\Decimal;

final class Balance
{
    public function __construct(
        private readonly ServiceInterface $service,
    ) {
    }

    public function fetch(
        int $accountId,
        ?DateTimeInterface $from = null,
        ?DateTimeInterface $to = null
    ): Decimal
    {
        return $this->service->getBalance($accountId, $from, $to);
    }
}
