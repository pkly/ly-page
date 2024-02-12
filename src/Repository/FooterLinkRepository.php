<?php

namespace App\Repository;

use App\Entity\FooterLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FooterLink>
 *
 * @method FooterLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method FooterLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method FooterLink[]    findAll()
 * @method FooterLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FooterLinkRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, FooterLink::class);
    }
}
