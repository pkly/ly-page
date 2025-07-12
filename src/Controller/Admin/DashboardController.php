<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Media\Mascot;
use App\Entity\Media\MascotGroup;
use App\Entity\Media\Tag;
use App\Entity\Media\TagGroup;
use App\Entity\Media\Wallpaper;
use App\Entity\Navigation\BlockGroup;
use App\Entity\Navigation\BlockLink;
use App\Entity\Navigation\FooterLink;
use App\Entity\Rss\Result;
use App\Entity\Rss\Search;
use App\Entity\Rss\Source;
use App\Media\WallpaperLinker;
use App\Types\WallpaperSelectedType;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\ColorScheme;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly WallpaperLinker $linker,
        private readonly RequestStack $stack,
        private readonly RouterInterface $router
    ) {
    }

    public function index(): Response
    {
        $form = $this->createForm(WallpaperSelectedType::class, [
            'tags' => $this->linker->current(),
        ]);

        $form->handleRequest($this->stack->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->linker->update($form->get('tags')->getData());
        }

        return $this->render('admin/dashboard.html.twig', [
            'wallpaperForm' => $form,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LyPage3')
            ->setDefaultColorScheme(ColorScheme::DARK);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addCssFile('assets/css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToUrl('Front page', 'fa fa-home', $this->router->generate('front.index'));

        yield MenuItem::section('RSS');
        yield MenuItem::linkToCrud('Source', null, Source::class);
        yield MenuItem::linkToCrud('Search', null, Search::class);
        yield MenuItem::linkToCrud('Result', null, Result::class);

        yield MenuItem::section('Navigation');
        yield MenuItem::linkToCrud('Block group', null, BlockGroup::class);
        yield MenuItem::linkToCrud('Block link', null, BlockLink::class);
        yield MenuItem::linkToCrud('Footer link', null, FooterLink::class);

        yield MenuItem::section('Media');
        yield MenuItem::linkToCrud('Tag Group', null, TagGroup::class);
        yield MenuItem::linkToCrud('Tag', null, Tag::class);
        yield MenuItem::linkToCrud('Mascot group', null, MascotGroup::class);
        yield MenuItem::linkToCrud('Mascot', null, Mascot::class);
        yield MenuItem::linkToCrud('Wallpaper', null, Wallpaper::class);
    }
}
