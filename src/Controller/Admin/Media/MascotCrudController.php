<?php

declare(strict_types=1);

namespace App\Controller\Admin\Media;

use App\Entity\Media\Mascot;
use App\Mascot\MascotProvider;
use App\Repository\Media\MascotGroupRepository;
use App\Repository\Media\MascotRepository;
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

class MascotCrudController extends AbstractCrudController
{
    private string|null $newMascotPath = null;
    private string|null $newMascotExt = null;

    public function __construct(
        #[Autowire(param: 'kernel.project_dir')] private readonly string $projectDir,
        private readonly MascotRepository $repository,
        private readonly MascotGroupRepository $mascotGroupRepository,
        private readonly MascotProvider $provider
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Mascot::class;
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
            ->setTemplatePath('admin/entity/mascot.path.html.twig')
            ->hideOnForm();

        yield AssociationField::new('tags')
            ->autocomplete();
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        $entityInstance->setPath($this->newMascotPath);
        $entityInstance->setExt($this->newMascotExt);

        parent::persistEntity($entityManager, $entityInstance);

        $this->refreshMascots();
    }

    public function updateEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        parent::updateEntity($entityManager, $entityInstance);

        $this->refreshMascots();
    }

    public function new(
        AdminContext $context
    ) {
        $mascots = $this->repository->getAllPaths();

        // find first new path
        foreach ((new Finder())->in($this->projectDir.'/public/mascots')->files() as $file) {
            $diffPath = substr($file->getRealPath(), strlen($this->projectDir.'/public'));

            if (!in_array($diffPath, $mascots)) {
                $this->newMascotPath = $diffPath;
                $this->newMascotExt = $file->getExtension();
                break;
            }
        }

        if (null === $this->newMascotPath) {
            $this->addFlash('warning', 'No new mascot to add');

            return $this->redirectToRoute('admin_mascot_index');
        }

        return parent::new($context);
    }

    public function configureResponseParameters(
        KeyValueStore $responseParameters
    ): KeyValueStore {
        $responseParameters->set('newImagePath', $this->newMascotPath);
        $responseParameters->set('newImageExt', $this->newMascotExt);

        return $responseParameters;
    }

    private function refreshMascots(): void
    {
        foreach ($this->mascotGroupRepository->findAll() as $group) {
            $this->provider->update($group);
        }
    }
}
