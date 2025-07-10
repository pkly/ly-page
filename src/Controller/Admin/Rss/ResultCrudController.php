<?php

namespace App\Controller\Admin\Rss;

use App\Entity\Rss\Result;
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

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('url');
        yield TextField::new('title');
        yield TextField::new('guid');
        yield DateTimeField::new('seenAt');
        yield AssociationField::new('search');
    }
}

//    #[ORM\Column(length: 2048)]
//    private ?string $url = null;
//
//    #[ORM\Column(length: 2048)]
//    private ?string $title = null;
//
//    #[ORM\Column]
//    private array $data = [];
//
//    #[ORM\Column(type: Types::GUID)]
//    private ?string $guid = null;
//
//    #[ORM\Column(nullable: true)]
//    private ?\DateTimeImmutable $seenAt = null;
//
//    #[ORM\ManyToOne(inversedBy: 'results')]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Search $search = null;