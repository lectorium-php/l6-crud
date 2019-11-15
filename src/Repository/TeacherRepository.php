<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    public function searchByName($query): array
    {
        $query = $this->createQueryBuilder('t')
//            ->where('t.firstName = :query')
//            ->setParameter('query', $query)
            ->where('t.firstName LIKE :query')
            ->setParameter(':query', "%$query%")
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        return $query->getResult();
    }
}
