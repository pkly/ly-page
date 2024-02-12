<?php

namespace App\Repository;

use App\Entity\SubLinkBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubLinkBlock>
 *
 * @method SubLinkBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubLinkBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubLinkBlock[]    findAll()
 * @method SubLinkBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubLinkBlockRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, SubLinkBlock::class);
    }
}
