<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ChatSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChatSession>
 *
 * @method ChatSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatSession[]    findAll()
 * @method ChatSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatSession::class);
    }

    // Vos méthodes de requête personnalisées viendront ici
}
