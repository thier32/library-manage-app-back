<?php

namespace App\Service;


use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;

interface ITransactionService extends IBaseService
{

    /**
     * @param TransactionCreateDto $transactionCreateDto
     * @return TransactionDto
     */
    public function createTransaction(TransactionCreateDto $transactionCreateDto):TransactionDto;


    /**
     * @param array|null $criteria
     * @return array
     */
    public function checkTransaction(?array $criteria = []): array;


    /**
     * @param array|null $criteria
     * @return array
     */
    public function listTransaction(?array $criteria = []): array;
}
