<?php

namespace App\Business\Impl;

use App\Business\IMemberBusiness;
use App\Dto\Book\BookCreateDto;
use App\Dto\Book\BookDto;
use App\Dto\Member\MemberCreateDto;
use App\Dto\Member\MemberDto;
use App\Service\IBookService;
use App\Service\IMemberService;


class MemberBusiness implements IMemberBusiness
{

    public function __construct(private IMemberService $memberService){}


    public function createMember(MemberCreateDto $memberCreateDto): MemberDto
    {
        return $this->memberService->createMember($memberCreateDto);
    }

    public function listMember(array $searchCriteria): array
    {
       return $this->memberService->getEntities(MemberDto::class, $searchCriteria);
    }
}
