<?php

namespace App\Service;

use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\Borrow\BorrowDto;

interface IBorrowService extends IBaseService
{
    /**
     * @param BorrowCreateDto $borrowCreateDto
     * @return BorrowDto
     */
    public function createBorrow(BorrowCreateDto $borrowCreateDto): BorrowDto;


    /**
     * @param array|null $criteria
     * @return array
     */
    public function findBorrow(?array $criteria =[]): array;
}
