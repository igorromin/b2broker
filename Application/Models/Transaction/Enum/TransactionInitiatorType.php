<?php

namespace Application\Models\Transaction\Enum;

enum TransactionInitiatorType
{
    case withdrawal;
    case topUp;
    case transfer;
}
