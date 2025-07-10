<?php

namespace App\Controller\Admin\Media;

use App\Entity\Media\WallpaperGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WallpaperGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WallpaperGroup::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title');

        yield AssociationField::new('tags')
            ->autocomplete();
    }
}