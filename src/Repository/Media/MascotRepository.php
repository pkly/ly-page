<?php

namespace App\Repository\Media;

use App\Entity\Media\Mascot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mascot>
 */
class MascotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
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
}
