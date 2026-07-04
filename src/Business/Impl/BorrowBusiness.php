<?php

namespace App\Business\Impl;

use App\Business\IBorrowBusiness;
use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;
use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\Borrow\BorrowDto;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Entity\Member;
use App\Service\IBookService;
use App\Service\IBorrowService;
use App\Service\IMemberService;
use App\Utils\Mapper;


class BorrowBusiness implements IBorrowBusiness
{
    public function __construct(
        private IBorrowService $borrowService,
        private IBookService $bookService,
        private IMemberService $memberService

    ){}

    public function createBorrow(BorrowCreateDto $borrowCreateDto): BorrowDto
    {
        $member = $this->memberService->getEntity([Member::MEMBER_ID => $borrowCreateDto->memberId]);
        $book = $this->bookService->getEntity([Book::BOOK_ID => $borrowCreateDto->bookId]);
        $borrow = Mapper::map($borrowCreateDto, Borrow::class);
        $borrow->setMember($member);
        $borrow->setBook($book);

        $borrow = $this->borrowService->addEntity($borrow);
        return Mapper::map($borrow, BorrowDto::class);
    }

    public function listBorrow(?array $searchCriteria = []): array
    {
        return $this->borrowService->getEntities(BorrowDto::class,$searchCriteria);
    }

}
