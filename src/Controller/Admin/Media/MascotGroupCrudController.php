<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\MascotGroup;
use App\Mascot\MascotProvider;
use App\Repository\Media\MascotGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MascotGroupCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly MascotGroupRepository $mascotGroupRepository,
        private readonly MascotProvider $provider
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return MascotGroup::class;
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title');

        yield AssociationField::new('tags')
            ->autocomplete();
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        parent::persistEntity($entityManager, $entityInstance);

        $this->refreshMascots();
    }

    public function updateEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        parent::updateEntity($entityManager, $entityInstance);

        $this->refreshMascots();
    }

    private function refreshMascots(): void
    {
        foreach ($this->mascotGroupRepository->findAll() as $group) {
            $this->provider->update($group);
        }
    }
}
