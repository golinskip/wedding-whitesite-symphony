<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findRoots(bool $is_public) {
        if($is_public) {
            return $this->findPublicRoots();
        }
        return $this->findPrivateRoots();
    }

    public function findPrivateRoots() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_root = 1')
            ->andWhere('p.is_public = 0')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPublicRoots() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_root = 1')
            ->andWhere('p.is_public = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPrivateRoot() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_root = 1')
            ->andWhere('p.is_public = 0')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findPublicRoot() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_root = 1')
            ->andWhere('p.is_public = 1')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findPrivateEnabled() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_enabled = 1')
            ->andWhere('p.is_public = 0')
            ->addOrderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPublicEnabled() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_enabled = 1')
            ->andWhere('p.is_public = 1')
            ->addOrderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySlugAndPrivacy($slug, $is_public): ?Page
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_enabled = 1')
            ->andWhere('p.is_public = '.($is_public?'1':'0'))
            ->andWhere('p.url_name = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Page[] Returns an array of Page objects
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
    public function findOneBySomeField($value): ?Page
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
