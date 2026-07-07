<?php

namespace App\Dto\Transaction;

use App\Dto\BaseDto;

class TransactionDto extends BaseDto
{
    public ?string $createdAt = null;

    /**
     * @param int|null $transactionId
     * @param int|null $amount
     * @param int|null $memberId
     * @param string|null $currency
     * @param string|null $status
     * @param string|null $referenceId
     * @param string|null $paymentMethod
     * @param \DateTimeInterface|string|null $createdDateAt
     * @param string|null $memberName
     */
    public function __construct(
        public ?int $transactionId = null,
        public ?int $amount = null,
        public ?int $memberId = null,
        public ?string $currency = 'XAF',
        public ?string $status = null,
        public ?string $referenceId = null,
        public ?string $paymentMethod = null,
        \DateTimeInterface|string|null $createdDateAt = null,
        public ?string $memberName = null
    )
    {
        $this->createdAt = $createdDateAt ? $createdDateAt->format('Y-m-d H:i:s') : null;
    }

}
