<?php

namespace Application\Models\Transaction;

use Application\Models\Account\Model as AccountModel;
use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Models\Transaction\Enum\TransactionType;

class Model
{
    public int $id;

    public AccountModel $account;

    public TransactionType $type;

    public TransactionInitiatorType $initiatorType;

    public int $initiatorId;

    public int $amount;

    public string $comment;

    public \DateTime $created;

    public ?\DateTime $executed;

    public ?\DateTime $updated;

    public ?\DateTime $deleted;
}
