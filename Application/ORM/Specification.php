<?php

namespace Application\ORM;

use Application\Types\SortType;

class Specification
{
    public function equal(string $property, mixed $value): static
    {
        return $this;
    }

    public function orderBy(string $property, SortType $orderDirection): static
    {
        return $this;
    }
}
