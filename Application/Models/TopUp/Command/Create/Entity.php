<?php

declare(strict_types=1);

namespace Application\Models\TopUp\Command\Create;

use Application\Models\PaymentProvider\Model as PaymentProviderModel;
use Decimal\Decimal;

final class Entity
{
    public int $accountId;

    public Decimal $amount;

    public PaymentProviderModel $paymentProvider;
}
