<?php

namespace App\Repository;

use App\Entity\Trick;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getComments(int $page, int $length, Trick $trick)
    {
        $queryBuilder = $this->createQueryBuilder('c')
        ->where('c.trick = :trick')
        ->setParameter('trick', $trick)
        ->orderBy('c.id', 'desc')
        ->setFirstResult(($page-1) * $length)
        ->setMaxResults($length)
        ;
        return $queryBuilder->getQuery()->getResult();
    }
}
