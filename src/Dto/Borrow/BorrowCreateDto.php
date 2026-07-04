<?php
namespace App\Dto\Borrow;


use App\Dto\BaseDto;

class BorrowCreateDto extends BaseDto
{
    public function __construct(
        public int $memberId,
        public int $bookId,
        public \DateTime $returnDate
    ){
    }
}
