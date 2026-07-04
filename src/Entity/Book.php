<?php
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book extends BaseEntity
{
    public const BOOK_ID = 'bookId';
    public const BOOK_TITLE = 'title';


    #[ORM\Column(type: Types::BIGINT,unique: true)]
    #[Groups("book_read")]
    private ?int $bookId = null;

    #[ORM\Column(length: 255)]
    #[Groups("book_read")]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups("book_read")]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups("book_read")]
    private ?\DateTimeInterface $publishedAt = null;


    #[ORM\Column]
    #[\Symfony\Component\Serializer\Annotation\Groups(['loan_read'])]
    #[OA\Property(description: "Indique si le livre est candidat à l'emprunt.", example: true)]
    private bool $available = true;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    /**
     * @param int|null $bookId
     */
    final public function setBookId(?int $bookId): static
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * @return bool
     */
    final public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * @param bool $available
     */
    final public function setAvailable(bool $available): static
    {
        $this->available = $available;
        return $this;
    }
}
