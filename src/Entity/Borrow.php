<?php
namespace App\Entity;

use App\Repository\BorrowRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
#[ORM\HasLifecycleCallbacks] // For automatic date handling
#[OA\Schema(
    description: "Modèle représentant l'emprunt d'un livre par un membre de la bibliothèque."
)]
class Borrow extends BaseEntity
{
    #[ORM\Column(type: Types::BIGINT,unique: true)]
    private ?int $borrowId = null;

    #[ORM\ManyToOne(targetEntity: Member::class)]
    #[ORM\JoinColumn(
        name: "member_id",
        referencedColumnName: "id",
        nullable: false,
        onDelete: "CASCADE"
    )]
    #[Assert\NotBlank(message: "Le membre emprunteur est obligatoire.")]
    #[Groups(['loan_read', 'loan_write'])]
    #[OA\Property(description: "Le membre qui effectue l'emprunt.")]
    private ?Member $member = null;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(
        name: "book_id",
        referencedColumnName: "id",
        nullable: false,
        onDelete: "CASCADE"
    )]
    #[Assert\NotBlank(message: "Le livre à emprunter est obligatoire.")]
    #[Groups(['loan_read', 'loan_write'])]
    #[OA\Property(description: "L'ouvrage emprunté.")]
    private ?Book $book = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['loan_read'])]
    #[OA\Property(description: "Date exacte de la sortie du livre.", format: "date", example: "2026-07-04")]
    private ?\DateTimeImmutable $loanDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message: "La date d'échéance de retour est obligatoire.")]
    #[Assert\GreaterThan(propertyPath: "loanDate", message: "La date de retour doit être postérieure à la date d'emprunt.")]
    #[Groups(['loan_read', 'loan_write'])]
    #[OA\Property(description: "Date limite fixée pour ramener l'ouvrage.", format: "date", example: "2026-07-25")]
    private ?\DateTimeImmutable $returnDueDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups(['loan_read'])]
    #[OA\Property(description: "Date effective à laquelle le livre a été restitué. Reste nulle tant que le livre est dehors.", format: "date", nullable: true, example: null)]
    private ?\DateTimeImmutable $returnedAt = null;

    #[ORM\Column]
    #[Groups(['loan_read'])]
    #[OA\Property(description: "Indique si l'emprunt est en cours (true) ou si le livre a été rendu (false).", example: true)]
    private bool $isActive = true;

    #[Groups(['loan_read'])]
    private string $bookAuthor;


    #[Groups(['loan_read'])]
    private string $bookTitle;

    #[Groups(['loan_read'])]
    private string $memberName;

    public function __construct()
    {
        // Automatically enforce loan initialization rules on object instantiation
        $this->loanDate = new \DateTimeImmutable();
        $this->isActive = true;
    }

    // =========================================================================
    // LIFECYCLE HOOKS
    // =========================================================================

    #[ORM\PrePersist]
    final public function ensureDates(): void
    {
        if ($this->loanDate === null) {
            $this->loanDate = new \DateTimeImmutable();
        }

        // Default rule: If no due date is provided, set it to J+21 days automatically
        if ($this->returnDueDate === null) {
            $this->returnDueDate = $this->loanDate->modify('+21 days');
        }
    }

    // =========================================================================
    // DOMAIN LOGIC METHODS (Business Logic)
    // =========================================================================

    /**
     * Clôture formellement l'emprunt en restituant le livre.
     */
    final public function terminateLoan(): self
    {
        $this->returnedAt = new \DateTimeImmutable();
        $this->isActive = false;

        return $this;
    }

    /**
     * Calcule si l'emprunt est en retard par rapport à la date du jour.
     */
    #[Groups(['loan_read'])]
    #[OA\Property(description: "Indique si l'emprunt a dépassé sa date d'échéance sans être rendu.", example: false)]
    final public function isOverdue(): bool
    {
        if (!$this->isActive) {
            return false;
        }

        return new \DateTimeImmutable() > $this->returnDueDate;
    }


    // =========================================================================
    // GETTERS & SETTERS
    // =========================================================================

    final public function getBorrowId(): ?int
    {
        return $this->borrowId;
    }

    /**
     * @param int|null $borrowId
     */
    final public function setBorrowId(?int $borrowId): static
    {
        $this->borrowId = $borrowId;
        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;
        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;
        return $this;
    }

    final public function getLoanDate(): ?\DateTimeImmutable
    {
        return $this->loanDate;
    }

    final public function setLoanDate(\DateTimeImmutable $loanDate): self
    {
        $this->loanDate = $loanDate;
        return $this;
    }

    final public function getReturnDueDate(): ?\DateTimeImmutable
    {
        return $this->returnDueDate;
    }

    final public function setReturnDueDate(?\DateTimeImmutable $returnDueDate): self
    {
        $this->returnDueDate = $returnDueDate;
        return $this;
    }

    final public function getReturnedAt(): ?\DateTimeImmutable
    {
        return $this->returnedAt;
    }

    final public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    final public function getIsActive(): bool
    {
        return $this->isActive;
    }


    /**
     * @return string
     */
    #[Groups(['loan_read'])]
    public function getBookAuthor(): string
    {
        $this->bookAuthor = $this->book?->getAuthor();
        return $this->bookAuthor;
    }

    /**
     * @param string $bookAuthor
     */
    public function setBookAuthor(string $bookAuthor): static
    {
        $this->bookAuthor = $bookAuthor;
        return $this;
    }

    /**
     * @return string
     */
    #[Groups(['loan_read'])]
    public function getBookTitle(): string
    {
        $this->bookTitle = $this->book?->getAuthor();

        return $this->bookTitle;
    }

    /**
     * @param string $bookTitle
     */
    public function setBookTitle(string $bookTitle): static
    {
        $this->bookTitle = $bookTitle;
        return $this;
    }

    /**
     * @return string
     */
    #[Groups(['loan_read'])]
    public function getMemberName(): string
    {
        $this->memberName = $this->member?->getName();
        return $this->memberName;
    }

    /**
     * @param string $memberName
     */
    public function setMemberName(string $memberName): static
    {
        $this->memberName = $memberName;
        return $this;
    }
}
