<?php

namespace App\Controller\Admin;

use App\Entity\MascotGroup;
use App\Service\MascotService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MascotGroupCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly MascotService $mascotService
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
        yield CollectionField::new('directories')
            ->setEntryType(ChoiceType::class)
            ->setFormTypeOption('entry_options.choices', array_combine($this->mascotService->getDirectories(), $this->mascotService->getDirectories()));
    }
}
