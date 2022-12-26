<?php

declare(strict_types=1);

namespace Application\Models\Account;

use DateTimeInterface;

final class Model
{
    public int $id;

    public int $userId;

    public DateTimeInterface $created;
}
