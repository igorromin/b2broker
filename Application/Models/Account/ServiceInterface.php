<?php

namespace Application\Models\Account;

interface ServiceInterface
{
    public function getBalance(int $accountId, ?\DateTime $from = null, ?\DateTime $to = null): int;
}
