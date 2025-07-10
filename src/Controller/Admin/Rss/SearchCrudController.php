<?php

namespace App\Controller\Admin\Rss;

use App\Entity\Rss\Search;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SearchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Search::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield AssociationField::new('source');
        yield TextField::new('query');
        yield TextField::new('directory');
        yield BooleanField::new('active');
    }
}
