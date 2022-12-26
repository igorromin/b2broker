<?php

namespace Application\Models\Transfer\Command\Create;

use Application\Models\PaymentProvider\Model as PaymentProviderModel;

class Entity
{
    public int $fromAccountId;

    public int $toAccountId;

    public int $amount;

    public string $comment;
}
