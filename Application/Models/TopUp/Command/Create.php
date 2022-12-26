<?php

namespace Application\Models\TopUp\Command;

use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Models\Transaction\Enum\TransactionType;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\TopUp\Command\Create\Entity;
use Application\Models\TopUp\Enum\Status;
use Application\Models\TopUp\Model;
use Application\Models\TopUp\RepositoryInterface;
use Application\Models\Transaction\Model as TransactionModel;
use Application\ORM\Transaction;

class Create
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private RepositoryInterface $repository,
        private TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function execute(Entity $entity): int
    {
        $transaction = new Transaction();
        $transaction->begin();
        try {
            $this->accountRepository->assignTransaction($transaction);
            $this->repository->assignTransaction($transaction);
            $this->transactionRepository->assignTransaction($transaction);

            $account = $this->accountRepository->getById($entity->accountId, true);
            $fee = $entity->paymentProvider->fee * $entity->amount;

            $model = new Model();
            $model->account = $account;
            $model->paymentProvider = $entity->paymentProvider;

            $model->amount = (int)($entity->amount - $fee);
            $model->status = Status::pending;
            $model = $this->repository->create($model);

            $transactionModel = new TransactionModel();
            $transactionModel->account = $account;
            $transactionModel->type = TransactionType::debit;
            $transactionModel->initiatorType = TransactionInitiatorType::topUp;
            $transactionModel->initiatorId = $model->id;
            $transactionModel->amount = $entity->amount;
            $transactionModel->comment = '';
            $tx = $this->transactionRepository->create($transactionModel);

            return $tx->id;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
