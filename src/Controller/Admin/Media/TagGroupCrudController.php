<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\TagGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TagGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TagGroup::class;
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title');
    }
}
