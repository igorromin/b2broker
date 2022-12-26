<?php

declare(strict_types=1);

namespace Application\Models\Transaction\Query\GetListByAccount;

use Decimal\Decimal;

final class Entity
{
    public int $id;

    public int $accountId;

    public Decimal $amount;

    public string $type;

    public string $initiator;

    public string $comment;
}
