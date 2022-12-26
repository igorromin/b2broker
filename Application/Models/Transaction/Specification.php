<?php

namespace Application\Models\Transaction;

use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Types\SortType;

class Specification extends \Application\ORM\Specification
{
    public function accountIdIs(int $id): static
    {
        return $this->equal('account_id', $id);
    }

    public function orderByComment(SortType $sortType): static
    {
        return $this->orderBy('comment', $sortType);
    }

    public function orderByDate(): static
    {
        return $this->orderBy('created', SortType::desc);
    }

    public function withdrawalIdEqual(int $id): static
    {
        return $this->equal('initiator_type', TransactionInitiatorType::withdrawal)
                ->equal('initiator_id', $id);
    }

    public function topUpIdEqual(int $id): static
    {
        return $this->equal('initiator_type', TransactionInitiatorType::topUp)
            ->equal('initiator_id', $id);
    }
}
