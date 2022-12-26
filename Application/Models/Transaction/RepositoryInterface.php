<?php

declare(strict_types=1);

namespace Application\Models\Transaction;

use Application\ORM\RepositoryInterface as BaseRepositoryInterface;
use DateTimeInterface;
use Decimal\Decimal;

interface RepositoryInterface extends BaseRepositoryInterface
{
    public function getById(int $id, bool $lock = false): ?Model;

    /**
     * @return array<Model>
     */
    public function get(Specification $specification): array;

    public function getBalance(int $userId, ?DateTimeInterface $from, ?DateTimeInterface $to): Decimal;

    public function create(Model $model): Model;

    public function update(int $id, Model $model): Model;

    //soft-delete
    public function delete(int $id): bool;
}
