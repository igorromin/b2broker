<?php

declare(strict_types=1);

namespace Application\Models\Transfer;

use Application\ORM\RepositoryInterface as BaseRepositoryInterface;

interface RepositoryInterface extends BaseRepositoryInterface
{
    public function getById(int $id): ?Model;

    public function create(Model $model): Model;
}
