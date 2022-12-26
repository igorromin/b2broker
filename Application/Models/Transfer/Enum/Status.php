<?php

declare(strict_types=1);

namespace Application\Models\Transfer\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
