<?php

namespace Application\Models\Transfer;

interface RepositoryInterface extends \Application\ORM\RepositoryInterface
{
    public function getById(int $id): ?Model;

    public function create(Model $model): Model;
}
