<?php

namespace App\Controller;

use App\Repository\Media\MascotRepository;
use App\Repository\Navigation\BlockGroupRepository;
use App\Repository\Navigation\FooterLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(
        BlockGroupRepository $blockGroupRepository,
        FooterLinkRepository $footerLinkRepository,
        MascotRepository $mascotRepository
    ): Response {
        return $this->render('base.html.twig', [
            'header' => '頑張ってねライちゃん！',
            'blocks' => $blockGroupRepository->findAll(),
            'footerLinks' => $footerLinkRepository->findBy([], orderBy: ['priority' => 'DESC']),
            'mascot' => $mascotRepository->findOneBy([]),
        ]);
    }
}
