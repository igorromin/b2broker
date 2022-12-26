<?php

namespace Application\Models\Transaction\Query\GetListByAccount;

use Application\Models\Transaction\Query\GetListByAccount\Enum\SortBy;
use Application\Types\SortType;

class Request
{
    public int $accountId;

    public ?SortBy $sortBy;

    public ?SortType $sortDirection;
}
