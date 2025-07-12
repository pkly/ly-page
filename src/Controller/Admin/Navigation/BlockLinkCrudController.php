<?php

declare(strict_types=1);

namespace App\Controller\Admin\Navigation;

use App\Entity\Navigation\BlockLink;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlockLinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlockLink::class;
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield AssociationField::new('block');
        yield TextField::new('title');
        yield TextField::new('url');
    }
}
