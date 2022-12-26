<?php

declare(strict_types=1);

namespace Application\Models\Withdrawal\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
