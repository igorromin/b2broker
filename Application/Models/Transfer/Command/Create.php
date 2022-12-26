<?php

namespace Application\Models\Transfer\Command;

use Application\Models\Account\Exception\InsufficientFunds;
use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\Account\ServiceInterface as AccountServiceInterface;
use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Models\Transaction\Enum\TransactionType;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\Transfer\Command\Create\Entity;
use Application\Models\Transfer\Enum\Status;
use Application\Models\Transfer\Model;
use Application\Models\Transfer\RepositoryInterface;
use Application\Models\Transaction\Model as TransactionModel;
use Application\ORM\Transaction;

class Create
{
    public function __construct(
        private AccountServiceInterface $accountService,
        private AccountRepositoryInterface $accountRepository,
        private RepositoryInterface $repository,
        private TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function execute(Entity $entity): bool
    {
        $transaction = new Transaction();
        $transaction->begin();
        try {
            $this->accountRepository->assignTransaction($transaction);
            $this->repository->assignTransaction($transaction);
            $this->transactionRepository->assignTransaction($transaction);

            $fromAccount = $this->accountRepository->getById($entity->fromAccountId, true);
            $toAccount = $this->accountRepository->getById($entity->toAccountId, true);

            $balance = $this->accountService->getBalance($entity->fromAccountId);
            if ($balance < $entity->amount) {
                throw new InsufficientFunds();
            }

            $model = new Model();
            $model->accountFrom = $fromAccount;
            $model->accountTo = $toAccount;
            $model->amount = $entity->amount;
            $model->status = Status::success;
            $model = $this->repository->create($model);

            $transactionModelFrom = new TransactionModel();
            $transactionModelFrom->account = $fromAccount;
            $transactionModelFrom->type = TransactionType::credit;
            $transactionModelFrom->initiatorType = TransactionInitiatorType::transfer;
            $transactionModelFrom->initiatorId = $model->id;
            $transactionModelFrom->amount = $entity->amount;
            $transactionModelFrom->comment = $entity->comment;
            $this->transactionRepository->create($transactionModelFrom);

            $transactionModelTo = new TransactionModel();
            $transactionModelTo->account = $toAccount;
            $transactionModelTo->type = TransactionType::debit;
            $transactionModelTo->initiatorType = TransactionInitiatorType::transfer;
            $transactionModelTo->initiatorId = $model->id;
            $transactionModelTo->amount = $entity->amount;
            $transactionModelTo->comment = $entity->comment;
            $this->transactionRepository->create($transactionModelTo);

            return true;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
