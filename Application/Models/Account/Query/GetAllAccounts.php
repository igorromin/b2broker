<?php

declare(strict_types=1);

namespace Application\Models\Account\Query;

use Application\Models\Account\Model;
use Application\Models\Account\Query\GetAllAccounts\Entity;
use Application\Models\Account\RepositoryInterface;

final class GetAllAccounts
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    ) {
    }

    /**
     * @return list<Entity>
     */
    public function fetch(): array
    {
        return array_map(
            static function (Model $model) {
                $entity = new Entity();
                $entity->id = $model->id;
                $entity->userId = $model->userId;

                return $entity;
            },
            $this->repository->getAll()
        );
    }
}
