<?php
namespace App\Controller;

use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\CriteriaDto;
use App\Response\BorrowResponseDto;

interface IBorrowController
{
    /**
     * @param BorrowCreateDto $borrowCreateDto
     * @return BorrowResponseDto
     */
    public function createBorrow(BorrowCreateDto $borrowCreateDto): BorrowResponseDto;


    /**
     * @param CriteriaDto|null $criteriaDto
     * @return BorrowResponseDto
     */
    public function listBorrow(
        ?CriteriaDto $criteriaDto = null): BorrowResponseDto;
}
