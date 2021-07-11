<?php

namespace App\Repository;

use App\Entity\AuthorRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|AuthorRole find($id, $lockMode = null, $lockVersion = null)
 * @method null|AuthorRole findOneBy(array $criteria, array $orderBy = null)
 * @method AuthorRole[]    findAll()
 * @method AuthorRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<AuthorRole>
 */
class AuthorRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorRole::class);
    }
}
