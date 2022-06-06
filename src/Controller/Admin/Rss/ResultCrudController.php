<?php

namespace App\Controller\Admin\Rss;

use App\Entity\Rss\Result;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResultCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Result::class;
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

        yield TextField::new('url');
        yield TextField::new('title');
        yield DateTimeField::new('seenAt');

        yield AssociationField::new('search');
    }
}
