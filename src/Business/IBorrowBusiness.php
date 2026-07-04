<?php

namespace App\Business;

use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\Borrow\BorrowDto;

interface IBorrowBusiness
{

    /**
     * @param BorrowCreateDto $borrowCreateDto
     * @return BorrowDto
     */
    public function createBorrow(BorrowCreateDto $borrowCreateDto): BorrowDto;


    /**
     * @param array|null $searchCriteria
     * @return array
     */
    public function listBorrow(?array $searchCriteria = []): array;
}
