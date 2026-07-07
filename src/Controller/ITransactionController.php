<?php
namespace App\Controller;

use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\CriteriaDto;
use App\Response\TransactionResponseDto;

interface ITransactionController
{
    /**
     * @param TransactionCreateDto $transactionCreateDto
     * @return TransactionResponseDto
     */
    public function createTransaction(TransactionCreateDto $transactionCreateDto): TransactionResponseDto;


    /**
     * @param CriteriaDto|null $criteriaDto
     * @return TransactionResponseDto
     */
    public function listTransactions(
        ?CriteriaDto $criteriaDto = null): TransactionResponseDto;


    /**
     * @param CriteriaDto|null $criteriaDto
     * @return TransactionResponseDto
     */
    public function checkTransaction(?CriteriaDto $criteriaDto): TransactionResponseDto;


}
