<?php

namespace App\Repository;

use App\Entity\InvitationGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InvitationGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvitationGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvitationGroup[]    findAll()
 * @method InvitationGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitationGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvitationGroup::class);
    }

    // /**
    //  * @return InvitationGroup[] Returns an array of InvitationGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvitationGroup
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
