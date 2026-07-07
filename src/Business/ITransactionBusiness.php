<?php

namespace App\Business;

use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;

interface ITransactionBusiness
{

    /**
     * @param TransactionCreateDto $transactionCreateDto
     * @return TransactionDto
     */
    public function createTransaction(TransactionCreateDto $transactionCreateDto): TransactionDto;


    /**
     * @param array|null $searchCriteria
     * @return array
     */
    public function listTransaction(?array $searchCriteria = []): array;

    /**
     * @param array $searchCriteria
     * @return array
     */
    public function checkTransaction(array $searchCriteria): array;
}
