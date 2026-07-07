<?php

namespace App\Business\Impl;

use App\Business\ITransactionBusiness;
use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;
use App\Entity\Member;
use App\Entity\Transaction;
use App\Service\IMemberService;
use App\Service\IPaymentService;
use App\Service\ITransactionService;
use App\Utils\Mapper;


class TransactionBusiness implements ITransactionBusiness
{
    public function __construct(
        private ITransactionService $transactionService,
        private IMemberService $memberService,
        private IPaymentService $paymentService
    ){}


    public function createTransaction(TransactionCreateDto $transactionCreateDto): TransactionDto
    {
        $member = $this->memberService->getEntity([Member::MEMBER_ID => $transactionCreateDto->memberId]);
        $transaction = Mapper::map($transactionCreateDto, Transaction::class);
        $transaction->setMember($member);

        $this->paymentService->payment($transactionCreateDto);

        $transaction = $this->transactionService->addEntity($transaction);
        return Mapper::map($transaction, TransactionDto::class);
    }

    public function listTransaction(?array $searchCriteria = []): array
    {
        return $this->transactionService->listTransaction($searchCriteria);
    }

    public function checkTransaction(array $searchCriteria): array
    {
        return $this->transactionService->checkTransaction($searchCriteria);
    }
}
