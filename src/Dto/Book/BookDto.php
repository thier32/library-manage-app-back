<?php

namespace App\Dto\Book;

use App\Dto\BaseDto;

class BookDto extends BaseDto
{
    public function __construct(
        public ?int $bookId = null,
        public ?string $title = null,
        public ?string $author = null,
        public ?bool $available = true,
        public ?\DateTimeInterface $publishedAt = null
    )
    {
    }
}
