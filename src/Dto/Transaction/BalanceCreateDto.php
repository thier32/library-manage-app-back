<?php

namespace App\Dto\Transaction;

use App\Dto\BaseDto;

class BalanceCreateDto extends BaseDto
{
    public function __construct(
        public ?string $accountNumber = null
    )
    {

    }
}
