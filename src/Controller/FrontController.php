<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Media\MascotGroup;
use App\Entity\Rss\Result;
use App\Mascot\MascotProvider;
use App\Repository\Media\MascotGroupRepository;
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
        ResultRepository $resultRepository,
        MascotGroupRepository $mascotGroupRepository,
        MascotProvider $provider
    ): Response {
        $mascotGroups = $mascotGroupRepository->findAll();
        $currentGroup = $mascotGroups[0] ?? null;
        $flash = null;

        // honestly all of this is kind of really garbage but at this time I don't really care lmao
        try {
            $session = $request->getSession();

            if ($session instanceof FlashBagAwareSessionInterface) {
                $flash = $session->getFlashBag()->get('info')[0] ?? null;
            }

            if (null !== ($mascotGroupId = $session->get('mascotGroupId'))) {
                $mascotGroupId = (int)$mascotGroupId;

                foreach ($mascotGroups as $group) {
                    if ($group->getId() === $mascotGroupId) {
                        $currentGroup = $group;
                    }
                }
            }
        } catch (SessionNotFoundException) {
        }

        return $this->render('base.html.twig', [
            'header' => '頑張ってねライちゃん！',
            'alert' => $flash,
            'rssResults' => $resultRepository->findBy(['seenAt' => null]),
            'blocks' => $blockGroupRepository->findAll(),
            'footerLinks' => $footerLinkRepository->findBy([], orderBy: ['priority' => 'DESC']),
            'mascot' => null !== $currentGroup ? $provider->get($currentGroup) : null,
            'currentMascotGroup' => $currentGroup,
            'mascotGroups' => $mascotGroups,
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

    #[Route('/mascot/set/{group}', name: 'front.mascot_set', methods: ['GET'])]
    public function setMascotGroup(
        MascotGroup $group,
        Request $request
    ): RedirectResponse {
        $request->getSession()->set('mascotGroupId', $group->getId());

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
