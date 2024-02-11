<?php

namespace App\Controller\Admin;

use App\Entity\MascotGroup;
use App\Entity\Rss\Group;
use App\Entity\Rss\Result;
use App\Entity\Rss\Search;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Homepage', 'fa fa-home', $this->generateUrl('front.index'));

        yield MenuItem::section();

        yield MenuItem::linkToUrl('Clear caches', 'fa fa-gem', $this->generateUrl('front.clear_cache'));

        yield MenuItem::section();

        yield MenuItem::linkToCrud('Mascot groups', 'fa fa-home', MascotGroup::class);

        yield MenuItem::section();

        yield MenuItem::linkToCrud('Groups', 'fa fa-home', Group::class);
        yield MenuItem::linkToCrud('Results', 'fa fa-home', Result::class);
        yield MenuItem::linkToCrud('Searches', 'fa fa-home', Search::class);
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->setDateFormat('Y-MM-d')
            ->setDateTimeFormat('Y-MM-dd hh:mm:ss');
    }
}
