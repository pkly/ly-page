<?php

namespace App\Controller;

use App\Repository\Rss\ResultRepository;
use App\Service\MascotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}