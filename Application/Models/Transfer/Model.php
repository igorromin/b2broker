<?php

namespace Application\Models\Transfer;

use Application\Models\Account\Model as AccountModel;
use Application\Models\Transfer\Enum\Status;

class Model
{
    public int $id;

    public AccountModel $accountFrom;

    public AccountModel $accountTo;

    public int $amount;

    public Status $status;

    public \DateTime $created;

    public ?\DateTime $updated;
}
