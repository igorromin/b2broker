<?php

declare(strict_types=1);

namespace Application\Models\Withdrawal\Command;

use Application\Exception\NotFound;
use Application\Models\Account\Exception\InsufficientFunds;
use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\Account\ServiceInterface as AccountServiceInterface;
use Application\Models\Transaction\Enum\TransactionInitiatorType;
use Application\Models\Transaction\Enum\TransactionType;
use Application\Models\Transaction\Model as TransactionModel;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\Withdrawal\Command\Create\Entity;
use Application\Models\Withdrawal\Enum\Status;
use Application\Models\Withdrawal\Model;
use Application\Models\Withdrawal\RepositoryInterface;
use Application\ORM\Transaction;

final class Create
{
    public function __construct(
        private readonly AccountServiceInterface $accountService,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly RepositoryInterface $repository,
        private readonly TransactionRepositoryInterface $transactionRepository,
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

            if ($account === null) {
                throw new NotFound(sprintf('Account %d not found', $entity->accountId));
            }

            $balance = $this->accountService->getBalance($entity->accountId);

            if ($balance < $entity->amount && $entity->amount > $entity->paymentProvider->minimumPayout) {
                throw new InsufficientFunds();
            }

            $fee = $entity->paymentProvider->fee->mul($entity->amount);

            $model = new Model();
            $model->account = $account;
            $model->paymentProvider = $entity->paymentProvider;

            $model->amount = $entity->amount->sub($fee);
            $model->status = Status::pending;
            $model = $this->repository->create($model);

            $transactionModel = new TransactionModel();
            $transactionModel->account = $account;
            $transactionModel->type = TransactionType::credit;
            $transactionModel->initiatorType = TransactionInitiatorType::withdrawal;
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
