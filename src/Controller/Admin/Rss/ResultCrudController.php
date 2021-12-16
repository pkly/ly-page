<?php

namespace App\Controller\Admin\Rss;

use App\Entity\Rss\Result;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ResultCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Result::class;
    }
}
