<?php

namespace App\Business\Impl;

use App\Business\IBookBusiness;
use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;
use App\Service\IBookService;


class BookBusiness implements IBookBusiness
{
    public function __construct(private IBookService $bookService){}

    public function createBook(BookCreateDto $bookCreateDto): BookDto
    {
        return $this->bookService->createBook($bookCreateDto);
    }

    public function listBook(array $searchCriteria = []): array
    {
        return $this->bookService->getEntities(BookDto::class,$searchCriteria);
    }
}
