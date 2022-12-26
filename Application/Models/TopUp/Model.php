<?php

declare(strict_types=1);

namespace Application\Models\TopUp;

use Application\Models\Account\Model as AccountModel;
use Application\Models\PaymentProvider\Model as PaymentProviderModel;
use Application\Models\TopUp\Enum\Status;
use DateTimeInterface;
use Decimal\Decimal;

final class Model
{
    public int $id;

    public AccountModel $account;

    public Decimal $amount;

    public Status $status;

    public PaymentProviderModel $paymentProvider;

    public DateTimeInterface $created;

    public ?DateTimeInterface $updated;
}
