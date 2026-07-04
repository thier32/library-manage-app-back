<?php
namespace App\Controller\Impl;

use App\Business\IBookBusiness;
use App\Controller\IBookController;
use App\Dto\Book\BookCreateDto;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Response\BookResponseDto;
use App\Service\IBookService;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController implements IBookController
{

    public function __construct(private IBookBusiness $bookBusiness)
    {
    }


    #[OA\Post(
        path: '/api/book',
        summary: 'Enregistrer un nouvel emprunt de livre',
        description: 'Vérifie les quotas du membre et la disponibilité du livre avant de valider la transaction de prêt.',
        operationId: 'createBookTransaction'
    )]
    #[OA\Tag(name: 'Livres')]
    #[OA\RequestBody(
        description: 'Données requises pour initialiser un livre',
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
    #[Route('/api/book', name: 'api_create_book', methods: ['POST'])]
    public function createBook(#[MapRequestPayload] BookCreateDto $borrowCreateDto): BookResponseDto
    {
        return new BookResponseDto(
            $this->bookBusiness->createBook(
                $borrowCreateDto
            )
        );
    }

    #[OA\Get(
        path: '/api/book',
        summary: 'Lister les livres',
        description: 'Lister les livres présents dans  le système',
        operationId: 'listBookTransaction'
    )]
    #[OA\Tag(name: 'Livres')]
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
    #[Route('/api/book', name: 'api_list_book', methods: ['GET'])]
    public function listBook(array $searchCriteria = []): BookResponseDto
    {
        return new BookResponseDto(
            $this->bookBusiness->listBook($searchCriteria)
        );
    }
}
