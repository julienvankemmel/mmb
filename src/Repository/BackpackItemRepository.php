<?php

namespace App\Repository;

use App\Entity\BackpackItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BackpackItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackpackItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackpackItem[]    findAll()
 * @method BackpackItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackpackItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackpackItem::class);
    }

    // /**
    //  * @return BackpackItem[] Returns an array of BackpackItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BackpackItem
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
