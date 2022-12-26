<?php

namespace Application\Models\Account\Query;

use Application\Models\Account\Model;
use Application\Models\Account\Query\GetAllAccounts\Entity;
use Application\Models\Account\RepositoryInterface;

class GetAllAccounts
{
    public function __construct(
        private RepositoryInterface $repository,
    ) {
    }

    public function fetch(): array
    {
        return array_map(
            function (Model $model) {
                $entity = new Entity();
                $entity->id = $model->id;
                $entity->userId = $model->userId;
                return $entity;
            },
            $this->repository->getAll()
        );
    }
}
