<?php

namespace App\Repository;

use App\Entity\PersonGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonGroup[]    findAll()
 * @method PersonGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonGroup::class);
    }

    // /**
    //  * @return PersonGroup[] Returns an array of PersonGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonGroup
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
