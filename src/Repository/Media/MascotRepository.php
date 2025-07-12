<?php

declare(strict_types=1);

namespace App\Repository\Media;

use App\Entity\Media\Mascot;
use App\Entity\Media\Tag;
use App\Entity\Media\Wallpaper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mascot>
 */
class MascotRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Mascot::class);
    }

    public function getAllPaths(): array
    {
        $results = $this->createQueryBuilder('m')
            ->select('m.path')
            ->getQuery()
            ->getArrayResult();

        return array_column($results, 'path');
    }

    /**
     * @param iterable<Tag> $tags
     *
     * @return list<Wallpaper>
     */
    public function findWithTags(
        iterable $tags
    ): array {
        $ids = [];

        foreach ($tags as $tag) {
            $ids[] = $tag->getId();
        }

        $ids = array_values(array_unique($ids));

        $qb = $this->createQueryBuilder('w')
            ->innerJoin('w.tags', 't');

        return $qb->where($qb->expr()->in('t.id', ':tagIds'))
            ->groupBy('w.id')
            ->having('COUNT(DISTINCT t.id) = :tagCount')
            ->setParameter('tagIds', $ids, ArrayParameterType::INTEGER)
            ->setParameter('tagCount', count($ids))
            ->getQuery()
            ->getResult();
    }
}
