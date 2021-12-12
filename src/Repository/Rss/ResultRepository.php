<?php

namespace App\Repository\Rss;

use App\Entity\Rss\Result;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Result|null find($id, $lockMode = null, $lockVersion = null)
 * @method Result|null findOneBy(array $criteria, array $orderBy = null)
 * @method Result[] findAll()
 * @method Result[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Result::class);
    }

    public function setAllAsSeen(): void
    {
        $this->createQueryBuilder('r')
            ->update(Result::class, 'r')
            ->set('r.seen', ':date')
            ->setParameter(':date', new \DateTime())
            ->getQuery()
            ->execute();
    }
}
