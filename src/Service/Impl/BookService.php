<?php

namespace App\Service\Impl;

use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;
use App\Dto\Book\MemberDto;
use App\Dto\Borrow\BorrowDto;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Repository\BookRepository;
use App\Service\IBookService;
use App\Utils\Mapper;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BookService extends BaseService implements IBookService
{
    public function __construct(private BookRepository $bookRepository,
                                public SerializerInterface $serializer
    ){

        parent::__construct(
            $this->bookRepository
        );
    }

    public function createBook(BookCreateDto $bookCreateDto): BookDto
    {
        return $this->addEntityDto($bookCreateDto,Book::class,BookDto::class);
    }
}
