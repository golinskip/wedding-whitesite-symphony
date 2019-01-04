<?php

namespace App\Repository;

use App\Entity\EventLogDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventLogDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventLogDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventLogDetail[]    findAll()
 * @method EventLogDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventLogDetailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventLogDetail::class);
    }

    // /**
    //  * @return EventLogDetail[] Returns an array of EventLogDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventLogDetail
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
