<?php

namespace Application\Models\TopUp\Command;

use Application\Exception\NotFound;
use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\Transaction\Specification;
use Application\Models\TopUp\Enum\Status;
use Application\Models\TopUp\Exception\IncorrectStatusTransition;
use Application\Models\TopUp\Exception\SameStatusTransition;
use Application\Models\TopUp\RepositoryInterface;
use Application\Models\Transaction\Model as TransactionModel;
use Application\ORM\Transaction;

class UpdateStatus
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private RepositoryInterface $repository,
        private TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function execute(int $id, Status $status): bool
    {
        $transaction = new Transaction();
        $transaction->begin();
        try {
            $this->accountRepository->assignTransaction($transaction);
            $this->repository->assignTransaction($transaction);
            $this->transactionRepository->assignTransaction($transaction);

            $model = $this->repository->getById($id, true);
            if ($model->status === $status) {
                throw new SameStatusTransition();
            }

            /** @var TransactionModel|null $transactionModel */
            $transactionModel = $this->transactionRepository->get((new Specification())->topUpIdEqual($id))[0] ?? null;
            if ($transactionModel === null) {
                throw new NotFound();
            }

            $model->status = $status;
            if ($status === Status::success) {
                $transactionModel->executed = new \DateTime();
                $this->transactionRepository->update($transactionModel->id, $transactionModel);
            } elseif ($status === Status::failed) {
                $this->transactionRepository->delete($transactionModel->id);
            } else {
                throw new IncorrectStatusTransition();
            }

            return (bool)$this->repository->update($id, $model);
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
