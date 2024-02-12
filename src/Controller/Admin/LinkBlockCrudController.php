<?php

namespace App\Controller\Admin;

use App\Entity\LinkBlock;
use App\Form\SubLinkBlockType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LinkBlockCrudController extends AbstractCrudController
{

    #[\Override]
    public static function getEntityFqcn(): string
    {
        return LinkBlock::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title');
        yield TextField::new('description');
        yield CollectionField::new('subLinkBlocks')
            ->setEntryType(SubLinkBlockType::class)
            ->setFormTypeOption('by_reference', false)
            ->allowAdd()
            ->allowDelete();
    }
}