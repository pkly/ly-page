<?php

declare(strict_types=1);

namespace App\Repository\Rss;

use App\Entity\Rss\Result;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Result>
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
            ->update()
            ->where('r.seenAt is null')
            ->set('r.seenAt', ':date')
            ->setParameter('date', new \DateTimeImmutable())
            ->getQuery()
            ->execute();
    }
}
