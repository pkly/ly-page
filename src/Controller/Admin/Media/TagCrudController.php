<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(
        Crud $crud
    ): Crud {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield AssociationField::new('tagGroup', 'Group')
            ->autocomplete();

        yield TextField::new('title');
    }
}
