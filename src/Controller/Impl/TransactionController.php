<?php
namespace App\Controller\Impl;

use App\Business\IMemberBusiness;
use App\Business\ITransactionBusiness;
use App\Controller\IMemberController;
use App\Controller\ITransactionController;
use App\Dto\CriteriaDto;
use App\Dto\Member\MemberCreateDto;
use App\Dto\Member\MemberDto;
use App\Dto\Transaction\TransactionCreateDto;
use App\Dto\Transaction\TransactionDto;
use App\Response\TransactionResponseDto;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class TransactionController extends AbstractController implements ITransactionController
{

    public function __construct(private ITransactionBusiness $transactionBusiness)
    {
    }


    #[OA\Post(
        path: '/api/transaction',
        summary: 'Enregistrer une nouvelle transaction',
        description: 'Ajouter une nouvelle transaction.',
        operationId: 'createTransactionTransaction'
    )]
    #[OA\Tag(name: 'Transactions')]
    #[OA\RequestBody(
        description: 'Données requises pour initialiser une transaction',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'memberId', type: 'integer', description: 'Identifiant du membre', example: '11112333333'),
                new OA\Property(property: 'referenceId', type: 'string', description: 'Le n° de compte', example: '237606779900'),
                new OA\Property(property: 'paymentMethod', type: 'string', description: 'Le moyen de paiement', example: 'momo'),
                new OA\Property(property: 'amount', type: 'integer', description: 'Le montant de la transaction', example: '900'),
                new OA\Property(property: 'description', type: 'string', description: 'La description de la transaction', example: 'description de la transaction'),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Transaction enregistré avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'transaction', ref: new Model(type: TransactionDto::class, groups: ['transaction_read']))
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
        response: 500,
        description: 'Erreur interne du serveur lors du traitement de la transaction.'
    )]
    #[Route('/api/transaction', name: 'api_create_transaction', methods: ['POST'])]
    public function createTransaction(#[MapRequestPayload] TransactionCreateDto $transactionCreateDto): TransactionResponseDto
    {
        return new TransactionResponseDto(
            $this->transactionBusiness->createTransaction($transactionCreateDto)
        );
    }

    #[OA\Get(
        path: '/api/transaction',
        summary: 'Lister les transactions',
        description: 'Affiche les transactions.',
        operationId: 'listTransactionTransaction'
    )]
    #[OA\Tag(name: 'Transactions')]
    #[OA\Response(
        response: 201,
        description: 'Liste transaction affichée avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'transaction', ref: new Model(type: TransactionDto::class, groups: ['transaction_read']))
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
        response: 500,
        description: 'Erreur interne du serveur lors du traitement de la transaction.'
    )]
    #[Route('/api/transaction', name: 'api_list_transaction', methods: ['GET'])]
    public function listTransactions(#[MapQueryString]
                                     ?CriteriaDto $criteriaDto = null): TransactionResponseDto
    {
        return new TransactionResponseDto(
            $this->transactionBusiness->listTransaction($criteriaDto?->criteria)
        );
    }


    #[OA\Get(
        path: '/api/transaction/status',
        summary: 'Verifier le status d\'une ou plusieurs transactions',
        description: 'Verifier le status d\'une ou plusieurs transactions.',
        operationId: 'statusTransactionTransaction'
    )]
    #[OA\Tag(name: 'Transactions')]
    #[OA\Response(
        response: 201,
        description: 'Transaction trouvée avec succès.',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'transaction', ref: new Model(type: TransactionDto::class, groups: ['transaction_read']))
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
        response: 500,
        description: 'Erreur interne du serveur lors du traitement de la transaction.'
    )]
    #[Route('/api/transaction/status', name: 'api_status_transaction', methods: ['GET'])]
    public function checkTransaction(#[MapQueryString]
                                     ?CriteriaDto $criteriaDto = null): TransactionResponseDto
    {
        return new TransactionResponseDto(
            $this->transactionBusiness->checkTransaction($criteriaDto->criteria)
        );
    }
}
