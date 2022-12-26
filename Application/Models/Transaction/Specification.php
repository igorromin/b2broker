<?php

declare(strict_types=1);

namespace Application\Models\Transaction;

use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\ORM\Specification as BaseSpecification;
use Application\Types\SortType;

final class Specification extends BaseSpecification
{
    public function accountIdIs(int $id): Specification
    {
        return $this->equal('account_id', $id);
    }

    public function orderByComment(SortType $sortType): Specification
    {
        return $this->orderBy('comment', $sortType);
    }

    public function orderByDate(): Specification
    {
        return $this->orderBy('created', SortType::desc);
    }

    public function withdrawalIdEqual(int $id): Specification
    {
        return $this->equal('initiator_type', TransactionInitiatorType::withdrawal->name)
                ->equal('initiator_id', $id);
    }

    public function topUpIdEqual(int $id): Specification
    {
        return $this->equal('initiator_type', TransactionInitiatorType::topUp->name)
            ->equal('initiator_id', $id);
    }
}
