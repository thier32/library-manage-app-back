<?php

namespace App\Service;

use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;


interface IBookService extends IBaseService
{
    public function createBook(BookCreateDto $bookCreateDto): BookDto;

}
