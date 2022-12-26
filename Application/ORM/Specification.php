<?php

declare(strict_types=1);

namespace Application\ORM;

use Application\Types\SortType;

class Specification
{
    public function equal(string $property, string|int $value): static
    {
        return $this;
    }

    public function orderBy(string $property, SortType $orderDirection): static
    {
        return $this;
    }
}
