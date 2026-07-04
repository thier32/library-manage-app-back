<?php

namespace App\Service\Impl;

use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\Borrow\BorrowDto;
use App\Entity\Borrow;
use App\Repository\BorrowRepository;
use App\Service\IBorrowService;

class BorrowService extends BaseService implements IBorrowService
{

    public function __construct(
        public BorrowRepository $borrowRepository
    )
    {
        parent::__construct(
            $this->borrowRepository
        );
    }

    public function createBorrow(BorrowCreateDto $borrowCreateDto): BorrowDto
    {
        return $this->addEntityDto($borrowCreateDto,Borrow::class,
        BorrowDto::class);
    }

    public function findBorrow(?array $criteria = []): array
    {
        return $this->borrowRepository->findLoansByCriteria($criteria);
    }

    public function getEntities(string $dtoClassName, ?array $criteria = []): array
    {
        $result = $this->findBorrow($criteria);
        return $this->convertMap($result,BorrowDto::class);
    }

}
