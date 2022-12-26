<?php

declare(strict_types=1);

namespace Application\Models\Transfer\Command\Create;

use Decimal\Decimal;

final class Entity
{
    public int $fromAccountId;

    public int $toAccountId;

    public Decimal $amount;

    public string $comment;
}
