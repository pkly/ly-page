<?php

namespace App\Controller;

use App\Enum\SessionOptions;
use App\Service\MascotService;
use App\Service\SplashTitleService;
use App\Traits\SessionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    use SessionTrait;

    #[Route("/")]
    public function index(
        string $BASE_TEMPLATE,
        MascotService $mascotService,
        SplashTitleService $splashTitleService
    ): Response {
        return $this->render(
            $BASE_TEMPLATE,
            [
                'body_title' => $splashTitleService->getTitle(),
                'mascot' => $mascotService->getMascot($this->getSession()?->get(SessionOptions::MASCOT_PATHS->value, []) ?? []),
            ]
        );
    }
}