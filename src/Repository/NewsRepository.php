<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function createQueryForPublic()
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.visibility = '.News::VISIBILITY_ALL.' OR n.visibility = '.News::VISIBILITY_PUBLIC)
            ->orderBy('n.start_publish_at', 'DESC')
            ->getQuery()
        ;
    }

    public function createQueryForPrivate()
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.visibility = '.News::VISIBILITY_ALL.' OR n.visibility = '.News::VISIBILITY_PRIVATE)
            ->orderBy('n.start_publish_at', 'DESC')
            ->getQuery()
        ;
    }

    public function findOneBySlugPublic($slug): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.url_name = :val')
            ->andWhere('n.visibility = '.News::VISIBILITY_ALL.' OR n.visibility = '.News::VISIBILITY_PUBLIC)
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneBySlugPrivate($slug): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.url_name = :val')
            ->andWhere('n.visibility = '.News::VISIBILITY_ALL.' OR n.visibility = '.News::VISIBILITY_PRIVATE)
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
