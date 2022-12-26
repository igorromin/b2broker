<?php

namespace Application\Models\Transaction\Query\GetListByAccount;

use Application\Models\Transaction\Query\GetListByAccount\Enum\SortBy;
use Application\Types\SortType;

class Entity
{
    public int $id;

    public int $accountId;

    public int $amount;

    public string $type;

    public string $initiator;

    public string $comment;
}
