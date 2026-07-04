<?php
namespace App\Controller;

use App\Dto\Book\BookCreateDto;
use App\Response\BookResponseDto;

interface IBookController
{
    /**
     * @param BookCreateDto $borrowCreateDto
     * @return BookResponseDto
     */
    public function createBook(BookCreateDto $borrowCreateDto): BookResponseDto;

    /**
     * @param array $searchCriteria
     * @return BookResponseDto
     */
    public function listBook(array $searchCriteria=[]): BookResponseDto;
}
