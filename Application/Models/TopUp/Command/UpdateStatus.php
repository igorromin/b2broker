<?php

declare(strict_types=1);

namespace Application\Models\TopUp\Command;

use Application\Exception\NotFound;
use Application\Models\Account\RepositoryInterface as AccountRepositoryInterface;
use Application\Models\TopUp\Enum\Status;
use Application\Models\TopUp\Exception\IncorrectStatusTransition;
use Application\Models\TopUp\Exception\SameStatusTransition;
use Application\Models\TopUp\RepositoryInterface;
use Application\Models\Transaction\Model as TransactionModel;
use Application\Models\Transaction\RepositoryInterface as TransactionRepositoryInterface;
use Application\Models\Transaction\Specification;
use Application\ORM\Transaction;

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

            $account = $this->repository->getById($id, true);

            if ($account === null) {
                throw new NotFound(sprintf('Account %d not found', $id));
            }

            if ($account->status === $status) {
                throw new SameStatusTransition();
            }

            /** @var TransactionModel|null $transactionModel */
            $transactionModel = $this->transactionRepository->get((new Specification())->topUpIdEqual($id))[0] ?? null;

            if ($transactionModel === null) {
                throw new NotFound();
            }

            $account->status = $status;

            if ($status === Status::success) {
                $transactionModel->executed = new \DateTimeImmutable();
                $this->transactionRepository->update($transactionModel->id, $transactionModel);
            } elseif ($status === Status::failed) {
                $this->transactionRepository->delete($transactionModel->id);
            } else {
                throw new IncorrectStatusTransition();
            }

            $this->repository->update($id, $account);
        } catch (\Exception $e) {
            $transaction->rollback();

            throw $e;
        }
    }
}
