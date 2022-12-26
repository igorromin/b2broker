<?php

namespace Application\Models\Transaction\Query;

use Application\Models\Transaction\Model;
use Application\Models\Transaction\Query\GetListByAccount\Entity;
use Application\Models\Transaction\Query\GetListByAccount\Enum\SortBy;
use Application\Models\Transaction\Query\GetListByAccount\Request;
use Application\Models\Transaction\RepositoryInterface;
use Application\Models\Transaction\Specification;

class GetListByAccount
{
    public function __construct(
        private RepositoryInterface $repository,
    ) {
    }

    public function fetch(Request $request): array
    {
        $specification = new Specification();
        $specification = match ($request->sortBy) {
            SortBy::comment => $specification->orderByComment($request->sortDirection),
            SortBy::date => $specification->orderByDate(),
            default => $specification,
        };
        if ($request->accountId) {
            $specification = $specification->accountIdIs($request->accountId);
        }

        return array_map(
            function (Model $model) {
                $entity = new Entity();
                $entity->id = $model->id;
                $entity->accountId = $model->account->id;
                $entity->amount = $model->amount;
                $entity->type = $model->type->name;
                $entity->initiator = $model->initiatorType->name;
                $entity->comment = $model->comment;
                return $entity;
            },
            $this->repository->get($specification)
        );
    }
}
