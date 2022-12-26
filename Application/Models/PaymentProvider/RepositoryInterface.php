<?php

declare(strict_types=1);

namespace Application\Models\PaymentProvider;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    public function getById(int $id): ?Model;

    public function create(Model $model): Model;
}
