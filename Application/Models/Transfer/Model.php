<?php

declare(strict_types=1);

namespace Application\Models\Transfer;

use Application\Models\Account\Model as AccountModel;
use Application\Models\Transfer\Enum\Status;
use DateTimeInterface;
use Decimal\Decimal;

class Model
{
    public int $id;

    public AccountModel $accountFrom;

    public AccountModel $accountTo;

    public Decimal $amount;

    public Status $status;

    public DateTimeInterface $created;

    public ?DateTimeInterface $updated;
}
