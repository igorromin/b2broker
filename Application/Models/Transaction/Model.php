<?php

declare(strict_types=1);

namespace Application\Models\Transaction;

use Application\Models\Account\Model as AccountModel;
use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Models\Transaction\Enum\TransactionType;
use DateTimeInterface;
use Decimal\Decimal;

final class Model
{
    public int $id;

    public AccountModel $account;

    public TransactionType $type;

    public TransactionInitiatorType $initiatorType;

    public int $initiatorId;

    public Decimal $amount;

    public string $comment;

    public DateTimeInterface $created;

    public ?DateTimeInterface $executed;

    public ?DateTimeInterface $updated;

    public ?DateTimeInterface $deleted;
}
