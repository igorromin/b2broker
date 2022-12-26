<?php

namespace Application\Models\Account;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id, bool $lock = false): ?Model;

    public function create(Model $model): Model;
}
