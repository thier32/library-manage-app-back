<?php

namespace App\Service\Impl;

use App\Dto\Member\MemberCreateDto;
use App\Dto\Member\MemberDto;
use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;
use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Service\IMemberService;
use App\Service\IPaymentService;

class PaymentService extends BaseService implements IPaymentService
{
    public function __construct(private MemberRepository $memberRepository
    ){

        parent::__construct(
            $this->memberRepository
        );
    }


    public function payment(TransactionCreateDto $transactionCreateDto): TransactionDto
    {
        return new TransactionDto();
    }
}
