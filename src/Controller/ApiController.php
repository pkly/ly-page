<?php

namespace App\Controller;

use App\Entity\Rss\Result;
use App\Repository\Rss\ResultRepository;
use App\Service\MascotService;
use App\Service\QBitTorrentService;
use App\Service\SplashTitleService;
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

    #[Route('/download-rss/{result}', name: 'download_rss', methods: ['GET'])]
    public function downloadRss(
        QBitTorrentService $service,
        Result $result,
        ResultRepository $repository
    ): Response {
        if (!$service->addTorrent($result)) {
            return new Response(status: Response::HTTP_FORBIDDEN);
        }

        // busy waiting to make it real
        $attempts = 10;

        while ($attempts > 0) {
            $attempts--;

            if (null === ($result = $repository->find($result->getId()))) {
                return new Response(status: Response::HTTP_NOT_FOUND);
            }

            if (null !== $result->getSeenAt()) {
                return new Response();
            }
        }

        return new Response(status: Response::HTTP_TOO_MANY_REQUESTS);
    }

    #[Route('/page-titles', name: 'page_titles', methods: ['GET'])]
    public function getPageTitles(
        SplashTitleService $service
    ): JsonResponse {
        return $this->json($service->getTitles());
    }
}
