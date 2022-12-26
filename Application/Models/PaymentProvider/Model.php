<?php

declare(strict_types=1);

namespace Application\Models\PaymentProvider;

use Decimal\Decimal;

final class Model
{
    public int $id;

    public string $name;

    public Decimal $minimumPayout;

    public Decimal $fee;
}
