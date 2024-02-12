<?php

namespace App\Repository;

use App\Entity\LinkBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkBlock>
 *
 * @method LinkBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkBlock[]    findAll()
 * @method LinkBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkBlockRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, LinkBlock::class);
    }
}
