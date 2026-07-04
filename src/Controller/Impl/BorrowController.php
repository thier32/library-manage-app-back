<?php
namespace App\Controller\Impl;

use App\Business\IBorrowBusiness;
use App\Controller\IBorrowController;
use App\Dto\Borrow\BorrowCreateDto;
use App\Dto\Borrow\BorrowDto;
use App\Dto\CriteriaDto;
use App\Dto\Member\MemberDto;
use App\Entity\Borrow;
use App\Response\BorrowResponseDto;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class BorrowController extends AbstractController implements IBorrowController
{

    public function __construct(
        public IBorrowBusiness $borrowBusiness
    ){}


    // 1. METADATA & SECURITY
    #[OA\Post(
        path: '/api/borrow',
        summary: 'Enregistrer un nouvel emprunt de livre',
        description: 'Faire un prêt de livre.',
        operationId: 'createLoanTransaction'
    )]
    #[OA\Tag(name: 'Emprunts')]
    #[OA\QueryParameter(
        name: 'force',
        description: 'Forcer le prêt même si le membre a dépassé son quota d\'emprunts',
        required: false,
        schema: new OA\Schema(type: 'boolean', default: false)
    )]

    // 3. REQUEST BODY (Payload description and model mapping)
    #[OA\RequestBody(
        description: 'Données requises pour initialiser un prêt',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'memberId', type: 'string', description: 'ID unique du membre', example: 'M-7721'),
                new OA\Property(property: 'bookId', type: 'string', description: 'ID unique ou code-barre du livre', example: 'B-0492'),
                new OA\Property(property: 'returnDueDate', type: 'string', format: 'date', description: 'Date d\'échéance du retour', example: '2026-07-25')
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Emprunt enregistré avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'loan', ref: new Model(type: Borrow::class, groups: ['loan_read']))
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données invalides ou manquantes (ex: format de date incorrect).'
    )]
    #[OA\Response(
        response: 401,
        description: 'Authentification JWT manquante ou invalide.'
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflit métier (ex: le livre est déjà emprunté ou le compte du membre est bloqué).',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'BOOK_ALREADY_BORROWED'),
                new OA\Property(property: 'message', type: 'string', example: 'Cet ouvrage n\'est pas disponible pour le moment.')
            ]
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Erreur interne du serveur lors du traitement de la transaction.'
    )]
    #[Route('api/borrow', name: 'api_create_borrow', methods: ['POST'])]
    public function createBorrow(#[MapRequestPayload] BorrowCreateDto $borrowCreateDto): BorrowResponseDto
    {
        return new BorrowResponseDto(
            $this->borrowBusiness->createBorrow(
                $borrowCreateDto
            )
        );
    }

    #[OA\Get(
        path: '/api/borrow',
        summary: 'Lister les emprunts',
        description: 'Vérifie les quotas du membre et la disponibilité du livre avant de valider la transaction de prêt.',
        operationId: 'listBorrowTransaction'
    )]
    #[OA\Tag(name: 'Emprunts')]
    #[OA\Response(
        response: 201,
        description: 'List Emprunt affichée avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'borrow', ref: new Model(type: BorrowDto::class, groups: ['loan_read']))
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données invalides ou manquantes (ex: format de date incorrect).'
    )]
    #[OA\Response(
        response: 401,
        description: 'Authentification JWT manquante ou invalide.'
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflit métier (ex: le livre est déjà emprunté ou le compte du membre est bloqué).',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'BOOK_ALREADY_BORROWED'),
                new OA\Property(property: 'message', type: 'string', example: 'Cet ouvrage n\'est pas disponible pour le moment.')
            ]
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Erreur interne du serveur lors du traitement de la transaction.'
    )]
    #[Route('/api/borrow', name: 'api_list_borrow', methods: ['GET'])]
    public function listBorrow(
        #[MapQueryString]
        ?CriteriaDto $criteriaDto = null): BorrowResponseDto
    {
        return new BorrowResponseDto(
            $this->borrowBusiness->listBorrow($criteriaDto?->criteria)
        );
    }
}
