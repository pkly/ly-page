<?php

declare(strict_types=1);

namespace App\Controller\Admin\Navigation;

use App\Entity\Navigation\BlockGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlockGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlockGroup::class;
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title');
        yield TextField::new('description');
    }
}
