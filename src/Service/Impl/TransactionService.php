<?php

namespace App\Service\Impl;

use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Service\ITransactionService;

class TransactionService extends BaseService implements ITransactionService
{

    public function __construct(
        public TransactionRepository $transactionRepository
    )
    {
        parent::__construct(
            $this->transactionRepository
        );
    }

    public function createTransaction(TransactionCreateDto $transactionCreateDto): TransactionDto
    {
        return $this->addEntityDto($transactionCreateDto,Transaction::class,
            TransactionDto::class);
    }

    public function checkTransaction(?array $criteria = []): array
    {
        if(empty($criteria)){
            $criteria = [];
        }

        return $this->transactionRepository->findByCriteria($criteria);
    }

    public function listTransaction(?array $criteria = []): array
    {
        if(empty($criteria)){
            $criteria = [];
        }
        return $this->transactionRepository->findByCriteria($criteria);
    }
}
