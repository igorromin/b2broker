<?php

declare(strict_types=1);

namespace Application\Models\Transaction\Enum;

enum TransactionInitiatorType
{
    case withdrawal;
    case topUp;
    case transfer;
}
