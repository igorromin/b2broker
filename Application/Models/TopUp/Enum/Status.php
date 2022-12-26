<?php

declare(strict_types=1);

namespace Application\Models\TopUp\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
