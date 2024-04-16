<?php

namespace App\Controller;

use App\Entity\Rss\Result;
use App\Repository\FooterLinkRepository;
use App\Repository\LinkBlockRepository;
use App\Repository\Rss\ResultRepository;
use App\Service\MascotService;
use App\Service\QBitTorrentService;
use App\Service\SplashTitleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api', name: 'api.')]
class ApiController extends AbstractController
{
    #[Route('/mascot-groups', name: 'mascot_groups', methods: ['GET'])]
    public function getMascotGroups(
        MascotService $service
    ): JsonResponse {
        return $this->json($service->getCachedGroups());
    }

    #[Route('/rss', name: 'rss', methods: ['GET'])]
    public function getRssFinds(
        ResultRepository $repository
    ): JsonResponse {
        return $this->json($repository->findBy(['seenAt' => null]), context: [
            AbstractNormalizer::GROUPS => [
                'api',
            ],
        ]);
    }

    #[Route('/mark-as-seen', name: 'mark_as_seen', methods: ['GET'])]
    public function markAllAsFound(
        ResultRepository $repository
    ): Response {
        $repository->setAllAsSeen();

        return new Response();
    }

    #[Route('/download-rss/{result}', name: 'download_rss', methods: ['GET'])]
    public function downloadRss(
        QBitTorrentService $service,
        Result $result,
        ResultRepository $repository,
        EntityManagerInterface $em
    ): Response {
        if (!$service->addTorrent($result)) {
            return new Response(status: Response::HTTP_FORBIDDEN);
        }

        // busy waiting to make it real
        $attempts = 10;

        while ($attempts > 0) {
            $attempts--;
            $em->clear();

            if (null === ($result = $repository->find($result->getId()))) {
                return new Response(status: Response::HTTP_NOT_FOUND);
            }

            if (null !== $result->getSeenAt()) {
                return new Response();
            }

            sleep(1);
        }

        return new Response(status: Response::HTTP_TOO_MANY_REQUESTS);
    }

    #[Route('/page-titles', name: 'page_titles', methods: ['GET'])]
    public function getPageTitles(
        SplashTitleService $service
    ): JsonResponse {
        return $this->json($service->getTitles());
    }

    #[Route('/footer-links', name: 'footer_links', methods: ['GET'])]
    public function getFooterLinks(
        FooterLinkRepository $repository
    ): JsonResponse {
        return $this->json($repository->findBy([], ['priority' => 'DESC']), context: [
            AbstractNormalizer::GROUPS => [
                'api',
            ],
        ]);
    }

    #[Route('/link-blocks', name: 'link_blocks', methods: ['GET'])]
    public function getLinkBlocks(
        LinkBlockRepository $repository
    ): JsonResponse {
        return $this->json($repository->findAll(), context: [
            AbstractNormalizer::GROUPS => [
                'api',
            ],
        ]);
    }
}
