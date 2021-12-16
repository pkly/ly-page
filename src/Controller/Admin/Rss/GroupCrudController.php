<?php

namespace App\Controller\Admin\Rss;

use App\Entity\Rss\Group;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Group::class;
    }
}
