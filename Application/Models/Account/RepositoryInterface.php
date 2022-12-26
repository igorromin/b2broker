<?php

declare(strict_types=1);

namespace Application\Models\Account;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    /**
     * @return list<Model>
     */
    public function getAll(): array;

    public function getById(int $id, bool $lock = false): ?Model;

    public function create(Model $model): Model;
}
