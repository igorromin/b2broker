<?php

namespace Application\Models\Transaction;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    public function getById(int $id, bool $lock = false): ?Model;

    public function get(Specification $specification): array;

    public function getBalance(int $userId, ?\DateTime $from, ?\DateTime $to): int;

    public function create(Model $model): Model;

    public function update(int $id, Model $model): Model;

    //soft-delete
    public function delete(int $id): bool;
}
