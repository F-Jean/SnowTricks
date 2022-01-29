<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;


class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, SluggerInterface $slugger)
    {
        parent::__construct($registry, Trick::class);
        $this->slugger = $slugger;
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
            ->setParameter('slug', $this->slugger->slug($trick->getName())->lower()->toString())
        ;

        if ($trick->getId() !== null) 
        {
        $queryBuilder
            ->andWhere('t != :trick')
            ->setParameter('trick', $trick)
        ;
        }

        return intval($queryBuilder
            ->getQuery()
            ->getSingleScalarResult()) > 0
        ;
    }
}
