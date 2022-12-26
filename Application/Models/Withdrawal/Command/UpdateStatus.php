<?php

declare(strict_types=1);

namespace Application\Models\Withdrawal\Command;

use Application\Exception\NotFound;
use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\Transaction\Model as TransactionModel;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\Transaction\Specification;
use Application\Models\Withdrawal\Enum\Status;
use Application\Models\Withdrawal\Exception\IncorrectStatusTransition;
use Application\Models\Withdrawal\Exception\SameStatusTransition;
use Application\Models\Withdrawal\RepositoryInterface;
use Application\ORM\Transaction;
use DateTimeImmutable;

final class UpdateStatus
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly RepositoryInterface $repository,
        private readonly TransactionRepositoryInterface $transactionRepository,
    ) {
    }

    public function execute(int $id, Status $status): void
    {
        $transaction = new Transaction();
        $transaction->begin();
        try {
            $this->accountRepository->assignTransaction($transaction);
            $this->repository->assignTransaction($transaction);
            $this->transactionRepository->assignTransaction($transaction);

            $withdrawal = $this->repository->getById($id, true);

            if ($withdrawal === null) {
                throw new NotFound(sprintf('Withdrawal %d not found', $id));
            }

            if ($withdrawal->status === $status) {
                throw new SameStatusTransition();
            }

            /** @var TransactionModel|null $transactionModel */
            $transactionModel = $this->transactionRepository->get(
                (new Specification())->withdrawalIdEqual($id)
            )[0] ?? null;

            if ($transactionModel === null) {
                throw new NotFound();
            }

            $withdrawal->status = $status;

            if ($status === Status::success) {
                $transactionModel->executed = new DateTimeImmutable();
                $this->transactionRepository->update($transactionModel->id, $transactionModel);
            } elseif ($status === Status::failed) {
                $this->transactionRepository->delete($transactionModel->id);
            } else {
                throw new IncorrectStatusTransition();
            }

            $this->repository->update($id, $withdrawal);
        } catch (\Exception $e) {
            $transaction->rollback();

            throw $e;
        }
    }
}
