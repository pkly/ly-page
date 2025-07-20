<?php

declare(strict_types=1);

namespace App\Repository\Rss;

use App\Entity\Rss\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Search>
 */
class SearchRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Search::class);
    }

    public function findNextToRefresh(): Search|null
    {
        $qb = $this->createQueryBuilder('s');

        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->isNull('s.lastSearchedAt'),
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('s.lastSearchedAt'),
                    $qb->expr()->isNull('s.lastFoundAt'),
                    $qb->expr()->lte('DATE_ADD(s.lastFoundAt, 1, \'HOUR\')', ':now')
                ),
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('s.lastSearchedAt'),
                    $qb->expr()->isNotNull('s.lastFoundAt'),
                    $qb->expr()->lte('DATE_ADD(s.lastFoundAt, 3, \'DAY\')', ':now'),
                    $qb->expr()->lte('DATE_ADD(s.lastSearchedAt, 3, \'HOUR\')', ':now'),
                )
            )
        );

        $qb->andWhere('s.active = 1');

        $qb->setMaxResults(1)
            ->orderBy('s.lastSearchedAt', 'ASC')
            ->addOrderBy('s.lastFoundAt', 'ASC')
            ->setParameter('now', new \DateTime(), Types::DATETIME_MUTABLE);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
