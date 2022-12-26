<?php

declare(strict_types=1);

namespace Application\Models\Transaction\Enum;

enum TransactionType
{
    case debit;
    case credit;
}
