<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\Wallpaper;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class WallpaperCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wallpaper::class;
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();
    }
}
