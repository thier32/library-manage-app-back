<?php
namespace App\Controller\Impl;

use App\Business\IMemberBusiness;
use App\Controller\IMemberController;
use App\Dto\Member\MemberCreateDto;
use App\Dto\Member\MemberDto;
use App\Entity\Book;
use App\Response\BookResponseDto;
use App\Response\MemberResponseDto;
use App\Service\IMemberService;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController implements IMemberController
{

    public function __construct(private IMemberBusiness $memberBusiness)
    {
    }


    #[OA\Post(
        path: '/api/member',
        summary: 'Enregistrer un nouveau membre',
        description: 'Ajouter un nouveau membre.',
        operationId: 'createMembreTransaction'
    )]
    #[OA\Tag(name: 'Membres')]
    #[OA\RequestBody(
        description: 'Données requises pour initialiser un membre',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string', description: 'Titre du livre', example: 'Madame Bauvary'),
                new OA\Property(property: 'author', type: 'string', description: 'Nom de l\'auteur', example: 'Gustave Flaubert'),
                new OA\Property(property: 'publishedDate', type: 'string', format: 'date', description: 'Date de publication', example: '1950-07-25')
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Book enregistré avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'book', ref: new Model(type: Book::class, groups: ['book_read']))
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
    #[Route('/api/member', name: 'api_create_member', methods: ['POST'])]
    public function createMember(#[MapRequestPayload] MemberCreateDto $memberCreateDto): MemberResponseDto
    {
        return new MemberResponseDto(
            $this->memberBusiness->createMember(
                $memberCreateDto
            )
        );
    }

    #[OA\Get(
        path: '/api/member',
        summary: 'Lister les membres',
        description: 'Vérifie les quotas du membre et la disponibilité du livre avant de valider la transaction de prêt.',
        operationId: 'listMemberTransaction'
    )]
    #[OA\Tag(name: 'Membres')]
    #[OA\Response(
        response: 201,
        description: 'Liste membres affichée avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'member', ref: new Model(type: MemberDto::class, groups: ['book_read']))
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
    #[Route('/api/member', name: 'api_list_member', methods: ['GET'])]
    public function listMember(array $searchCriteria = []): MemberResponseDto
    {
        return new MemberResponseDto(
            $this->memberBusiness->listMember($searchCriteria)
        );
    }
}
