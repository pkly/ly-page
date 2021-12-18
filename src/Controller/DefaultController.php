<?php

namespace App\Controller;

use App\Entity\MascotGroup;
use App\Entity\Rss\Result;
use App\Enum\SessionOptions;
use App\Repository\MascotGroupRepository;
use App\Repository\Rss\ResultRepository;
use App\Service\MascotService;
use App\Service\SplashTitleService;
use App\Traits\EntityManagerTrait;
use App\Traits\SessionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultController extends AbstractController
{
    use SessionTrait;
    use EntityManagerTrait;

    public const MASCOT_UPDATE_IN_SECONDS = 60;

    public function __construct(
        private readonly ResultRepository $resultRepository,
        private readonly HttpClientInterface $client
    ) {
    }

    #[Route("/", name: 'front.index')]
    public function index(
        string $BASE_TEMPLATE,
        MascotService $mascotService,
        SplashTitleService $splashTitleService,
        MascotGroupRepository $mascotGroupRepository,
        ResultRepository $resultRepository
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
                'rss_results' => $this->resultRepository->findBy(['seenAt' => null], ['id' => 'ASC'], 10),
            ]
        );
    }

    #[Route('/proxy/{file}', name: 'front.file_proxy')]
    public function proxy(
        Result $file
    ): Response {
        $response = $this->client->request('GET', $file->getUrl());
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return new Response('Failed to download file', 500);
        }

        $file->setSeenAt(new \DateTimeImmutable());
        $this->em->persist($file);
        $this->em->flush();

        return $this->download($response->getContent(), 'file-'.$file->getId().'.torrent', $response->getHeaders()['content-type'][0] ?? 'text/plain');
    }

    #[Route('/mark-all-as-seen', name: 'front.mark_all_as_seen')]
    public function setAllAsSeen(): RedirectResponse
    {
        $this->resultRepository->setAllAsSeen();
        return $this->redirectToRoute('front.index');
    }

    #[Route('/set-mascot-group/{group}', name: 'front.set_mascot_group')]
    public function setMascotGroup(
        ?MascotGroup $group
    ): RedirectResponse {
        $this->getSession()?->set(SessionOptions::MASCOT_GROUP->value, $group);
        $this->getSession()?->set(SessionOptions::MASCOT_COUNTER->value, 0);
        return $this->redirectToRoute('front.index');
    }

    /**
     * Generate a download
     *
     * @param string $contents
     * @param string $filename
     * @param string $mime
     * @param string $disposition
     *
     * @return Response
     */
    protected function download(
        string $contents,
        string $filename,
        string $mime = 'text/plain',
        string $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT
    ): Response {
        $response = new Response();
        $ext = explode('.', $filename);

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', $mime);
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition($disposition, $filename, 'file.'.$ext[count($ext)-1])
        );

        $response->setContent($contents);

        return $response;
    }
}
