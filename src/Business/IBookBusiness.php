<?php

namespace App\Business;

use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;
use App\Response\BookResponseDto;

interface IBookBusiness
{
    /**
     * @param BookCreateDto $bookCreateDto
     * @return BookDto
     */
    public function createBook(BookCreateDto $bookCreateDto): BookDto;

    /**
     * @param array $searchCriteria
     * @return array
     */
    public function listBook(array $searchCriteria=[]): array;
}
