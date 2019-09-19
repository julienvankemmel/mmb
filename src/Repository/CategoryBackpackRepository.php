<?php

namespace App\Repository;

use App\Entity\CategoryBackpack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryBackpack|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryBackpack|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryBackpack[]    findAll()
 * @method CategoryBackpack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryBackpackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryBackpack::class);
    }

    // /**
    //  * @return CategoryBackpack[] Returns an array of CategoryBackpack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryBackpack
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
