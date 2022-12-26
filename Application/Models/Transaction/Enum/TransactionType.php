<?php

namespace Application\Models\Transaction\Enum;

enum TransactionType
{
    case debit;
    case credit;
}
