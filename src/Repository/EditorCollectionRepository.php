<?php

namespace App\Repository;

use App\Entity\EditorCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|EditorCollection find($id, $lockMode = null, $lockVersion = null)
 * @method null|EditorCollection findOneBy(array $criteria, array $orderBy = null)
 * @method EditorCollection[]    findAll()
 * @method EditorCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<EditorCollection>
 */
class EditorCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EditorCollection::class);
    }

    public function findAllOrderByEditor(): array
    {
        return $this->createQueryBuilder('c')
            ->select(['c', 'e'])
            ->leftJoin('c.editor', 'e')
            ->orderBy('e.name', 'ASC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
