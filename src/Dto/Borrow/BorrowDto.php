<?php
namespace App\Dto\Borrow;


use App\Dto\BaseDto;

class BorrowDto extends BaseDto
{
    public function __construct(
        public int $borrowId,
        public int $memberId,
        public int $bookId,
        public string|\DateTime|null $returnDueDate,
        public string|\DateTime|null $loanDate,
        public ?string $bookTitle = null,
        public ?string $bookAuthor = null,
        public ?string $memberName = null,
    ){
    }

}
