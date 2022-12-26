<?php

namespace Application\Models\Withdrawal\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
