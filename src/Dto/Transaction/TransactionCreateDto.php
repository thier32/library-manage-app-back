<?php

namespace App\Dto\Transaction;

use App\Dto\BaseDto;

class TransactionCreateDto extends BaseDto
{
    public function __construct(
        public ?int $memberId = null,
        public ?string $referenceId = null,
        public ?string $paymentMethod = null,
        public ?float $amount = null,
        public ?string $description = null
    )
    {
    }
}
