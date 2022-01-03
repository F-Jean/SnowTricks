<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function getTricks(int $page, int $length)
    {
        $queryBuilder = $this->createQueryBuilder('t')
        ->orderBy('t.id', 'desc')
        ->setFirstResult(($page-1) * $length)
        ->setMaxResults($length)
        ;
        return $queryBuilder->getQuery()->getResult();
    }

    public function slugExists(Trick $trick): bool
    {
        $queryBuilder = $this->createQueryBuilder('t')
        ->select('COUNT(t.id)')
        ->andWhere('t.slug = :slug')
        ->setParameter('slug', $trick->getSlug());

        if ($trick->getId() === null) {
        $queryBuilder
        ->andWhere('t != :trick')
        ->setParameter('trick', $trick);
        }

        return intval($queryBuilder
        ->getQuery()
        ->getSingleScalarResult()) > 0;
    }
}
