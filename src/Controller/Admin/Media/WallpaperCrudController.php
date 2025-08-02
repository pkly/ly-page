<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\Wallpaper;
use App\Repository\Media\WallpaperRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;

class WallpaperCrudController extends AbstractCrudController
{
    private string|null $newImagePath = null;
    private string|null $newImageExt = null;

    public function __construct(
        #[Autowire(param: 'kernel.project_dir')] private readonly string $projectDir,
        private readonly WallpaperRepository $repository
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Wallpaper::class;
    }

    public function configureCrud(
        Crud $crud
    ): Crud {
        return $crud->overrideTemplate('crud/new', 'admin/entity/image.add.html.twig');
    }

    public function configureFields(
        string $pageName
    ): iterable {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('path')
            ->setTemplatePath('admin/entity/wallpaper.path.html.twig')
            ->hideOnForm();

        yield AssociationField::new('tags')
            ->autocomplete();
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        $entityInstance->setPath($this->newImagePath);
        $entityInstance->setExt($this->newImageExt);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function new(
        AdminContext $context
    ) {
        $mascots = $this->repository->getAllPaths();

        // find first new path
        foreach ((new Finder())->in($this->projectDir.'/public/walls')->files() as $file) {
            $diffPath = substr($file->getRealPath(), strlen($this->projectDir.'/public/walls/'));

            if (!in_array($diffPath, $mascots)) {
                $this->newImagePath = $diffPath;
                $this->newImageExt = $file->getExtension();
                break;
            }
        }

        if (null === $this->newImagePath) {
            $this->addFlash('warning', 'No new wallpaper to add');

            return $this->redirectToRoute('admin_wallpaper_index');
        }

        return parent::new($context);
    }

    public function configureResponseParameters(
        KeyValueStore $responseParameters
    ): KeyValueStore {
        $responseParameters->set('newImagePath', '/walls/'.$this->newImagePath);
        $responseParameters->set('newImageExt', $this->newImageExt);

        return $responseParameters;
    }
}
