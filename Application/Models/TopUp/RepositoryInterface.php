<?php

namespace Application\Models\TopUp;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    public function getById(int $id, bool $lock = false): ?Model;

    public function create(Model $model): Model;

    public function update(int $id, Model $model): Model;
}
