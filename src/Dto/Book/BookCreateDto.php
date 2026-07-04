<?php

namespace App\Dto\Book;

use App\Dto\BaseDto;
use Doctrine\DBAL\Types\Types;

class BookCreateDto extends BaseDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $author = null,
        public ?string $publishedAt = null
    )
    {
    }
}
