<?php

declare(strict_types=1);

namespace App\Repository\Rss;

use App\Entity\Rss\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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
                ),
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('s.lastSearchedAt'),
                    $qb->expr()->lte('DATE_ADD(s.lastFoundAt, 1, \'DAY\')', ':now')
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
