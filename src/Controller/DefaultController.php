<?php

namespace App\Controller;

use App\Service\MascotService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route("/")]
    #[Template("base.html.twig")]
    public function index(
        MascotService $mascotService
    ): array {
        dump($mascotService);
        dump($mascotService->getMascot());
        dump($mascotService->getDirectories());
        return [];
    }
}