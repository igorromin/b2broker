<?php

namespace Application\Models\Withdrawal;

use Application\Models\Account\Model as AccountModel;
use Application\Models\PaymentProvider\Model as PaymentProviderModel;
use Application\Models\Withdrawal\Enum\Status;

class Model
{
    public int $id;

    public AccountModel $account;

    public int $amount;

    public Status $status;

    public PaymentProviderModel $paymentProvider;

    public \DateTime $created;

    public ?\DateTime $updated;
}
