<?php

namespace Application\Models\Account\Query;

use Application\Models\Account\ServiceInterface;

class Balance
{
    public function __construct(
        private ServiceInterface $service,
    ) {
    }

    public function fetch(int $accountId, ?\DateTime $from = null, ?\DateTime $to = null): int
    {
        return $this->service->getBalance($accountId, $from, $to);
    }
}
