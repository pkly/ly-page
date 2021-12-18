<?php

namespace App\Controller;

use App\Entity\MascotGroup;
use App\Enum\SessionOptions;
use App\Repository\MascotGroupRepository;
use App\Service\MascotService;
use App\Service\SplashTitleService;
use App\Traits\SessionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    use SessionTrait;

    #[Route("/", name: 'front.index')]
    public function index(
        string $BASE_TEMPLATE,
        MascotService $mascotService,
        SplashTitleService $splashTitleService,
        MascotGroupRepository $mascotGroupRepository
    ): Response {
        /** @var MascotGroup|null $group */
        $group = $this->getSession()?->get(SessionOptions::MASCOT_GROUP->value);
        return $this->render(
            $BASE_TEMPLATE,
            [
                'body_title' => $splashTitleService->getTitle(),
                'mascot' => $mascotService->getMascot(
                    $this->getSession()?->get(SessionOptions::MASCOT_COUNTER->value, 0) ?? 0,
                    $group?->getDirectories() ?? []
                ),
                'mascot_groups' => $mascotGroupRepository->findAll(),
                'mascot_group' => $group,
            ]
        );
    }

    #[Route('/set-mascot-group/{group}', name: 'front.set_mascot_group')]
    public function setMascotGroup(
        ?MascotGroup $group
    ): RedirectResponse {
        $this->getSession()?->set(SessionOptions::MASCOT_GROUP->value, $group);
        return $this->redirectToRoute('front.index');
    }
}
