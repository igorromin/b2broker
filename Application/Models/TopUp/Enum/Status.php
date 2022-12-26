<?php

namespace Application\Models\TopUp\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
