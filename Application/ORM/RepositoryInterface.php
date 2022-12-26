<?php

namespace Application\ORM;

interface RepositoryInterface
{
    public function assignTransaction(Transaction $transaction): void;
}
