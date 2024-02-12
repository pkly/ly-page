<?php

namespace App\Repository;

use App\Entity\MascotGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MascotGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method MascotGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method MascotGroup[] findAll()
 * @method MascotGroup[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MascotGroupRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, MascotGroup::class);
    }

    public function getDefault(): MascotGroup|null
    {
        return $this->findBy(['defaultGroup' => true], ['id' => 'DESC'], 1)[0] ?? null;
    }
}
