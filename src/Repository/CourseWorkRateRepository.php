<?php

namespace App\Repository;

use App\Entity\CourseWorkRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CourseWorkRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseWorkRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseWorkRate[]    findAll()
 * @method CourseWorkRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseWorkRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseWorkRate::class);
    }

    // /**
    //  * @return CourseWorkRate[] Returns an array of CourseWorkRate objects
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
    public function findOneBySomeField($value): ?CourseWorkRate
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
