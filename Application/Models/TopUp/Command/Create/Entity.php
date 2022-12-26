<?php

namespace Application\Models\TopUp\Command\Create;

use Application\Models\PaymentProvider\Model as PaymentProviderModel;

class Entity
{
    public int $accountId;

    public int $amount;

    public PaymentProviderModel $paymentProvider;
}
