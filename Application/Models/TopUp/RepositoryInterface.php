<?php

declare(strict_types=1);

namespace Application\Models\TopUp;

use Application\ORM\RepositoryInterface as BaseRepositoryInterface;

interface RepositoryInterface extends BaseRepositoryInterface
{
    public function getById(int $id, bool $lock = false): ?Model;

    public function create(Model $model): Model;

    public function update(int $id, Model $model): Model;
}
