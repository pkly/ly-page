<?php

namespace App\Controller\Admin\Navigation;

use App\Entity\Navigation\FooterLink;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FooterLinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FooterLink::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('url');
        yield TextField::new('title');
        yield NumberField::new('priority');
    }
}
