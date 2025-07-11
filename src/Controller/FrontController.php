<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Rss\Result;
use App\Repository\Media\MascotRepository;
use App\Repository\Navigation\BlockGroupRepository;
use App\Repository\Navigation\FooterLinkRepository;
use App\Repository\Rss\ResultRepository;
use App\Torrent\QBitTorrentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'front.index', methods: ['GET'])]
    public function index(
        Request $request,
        BlockGroupRepository $blockGroupRepository,
        FooterLinkRepository $footerLinkRepository,
        MascotRepository $mascotRepository,
        ResultRepository $resultRepository
    ): Response {
        $flash = null;

        try {
            $session = $request->getSession();

            if ($session instanceof FlashBagAwareSessionInterface) {
                $flash = $session->getFlashBag()->get('info')[0] ?? null;
            }
        } catch (SessionNotFoundException) {
        }

        return $this->render('base.html.twig', [
            'header' => '頑張ってねライちゃん！',
            'alert' => $flash,
            'rssResults' => $resultRepository->findBy(['seenAt' => null]),
            'blocks' => $blockGroupRepository->findAll(),
            'footerLinks' => $footerLinkRepository->findBy([], orderBy: ['priority' => 'DESC']),
            'mascot' => $mascotRepository->findOneBy([]),
        ]);
    }

    #[Route('/seen-everything', name: 'front.set_all_as_seen', methods: ['GET'])]
    public function setAllAsSeen(
        ResultRepository $repository
    ): RedirectResponse {
        $repository->setAllAsSeen();
        $this->addFlash('info', 'Marked all as seen');

        return $this->redirectToRoute('front.index');
    }

    #[Route('/rss/start/{rss}', name: 'front.rss_result_start', methods: ['GET'])]
    public function startRssDownload(
        Result $rss,
        QBitTorrentService $service
    ): RedirectResponse {
        $this->addFlash('info', match ($service->add($rss)) {
            true => 'Started download of '.$rss->getTitle(),
            false => 'Failed to start download of '.$rss->getTitle(),
        });

        return $this->redirectToRoute('front.index');
    }
}
