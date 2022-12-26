<?php

namespace Application\Models\Transfer\Enum;

enum Status
{
    case pending;
    case success;
    case failed;
}
