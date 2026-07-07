<?php
namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Attributes as OA;


#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[OA\Schema(
    description: "Modèle représentant les transactions d'un membre."
)]
class Transaction extends BaseEntity
{
    #[ORM\Column(type: Types::BIGINT,unique: true)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?int $transactionId = null;

    #[ORM\Column(type: Types::BIGINT)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?int $amount = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?string $currency = 'XAF';

    #[ORM\Column(type: Types::STRING)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?string $description;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?string $status = 'PENDING';

    #[ORM\Column(type: Types::STRING)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?string $referenceId = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(["transaction_read","transaction_write"])]
    private ?string $paymentMethod = null;


    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    public function __construct() {
    }

    public function getTransactionId(): ?int
    {
        return $this->transactionId;
    }

    public function setTransactionId(?int $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): void
    {
        $this->member = $member;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
