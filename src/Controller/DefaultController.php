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

    public const MASCOT_UPDATE_IN_SECONDS = 60;

    #[Route("/", name: 'front.index')]
    public function index(
        string $BASE_TEMPLATE,
        MascotService $mascotService,
        SplashTitleService $splashTitleService,
        MascotGroupRepository $mascotGroupRepository
    ): Response {
        /** @var MascotGroup|null $group */
        $group = $this->getSession()?->get(SessionOptions::MASCOT_GROUP->value);
        // since we cannot really cache the SplInfo, we'll just fetch the last count
        $lastUpdate = $this->getSession()?->get(SessionOptions::LAST_MASCOT_UPDATE->value);
        $counter = $this->getSession()?->get(SessionOptions::MASCOT_COUNTER->value, 0) ?? 0;

        $mascot = $mascotService->getMascot(
            $counter,
            $group?->getDirectories() ?? []
        );

        if (null === $lastUpdate) {
            $lastUpdate = time();
        }

        if ($lastUpdate + self::MASCOT_UPDATE_IN_SECONDS < time()) {
            $counter++;

            if ($counter >= $mascotService->getLastMascotCount()) {
                $counter = 0; // reset counter
            }

            $this->getSession()?->set(SessionOptions::MASCOT_COUNTER->value, $counter);
        }

        return $this->render(
            $BASE_TEMPLATE,
            [
                'body_title' => $splashTitleService->getTitle(),
                'mascot' => $mascot,
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
