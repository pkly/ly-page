<?php

namespace App\Controller;

use App\Entity\Rss\Result;
use App\Service\MascotService;
use App\Service\QBitTorrentService;
use App\Service\RewriteService;
use App\Traits\EntityManagerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultController extends AbstractController
{
    use EntityManagerTrait;

    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    #[Route('/clear-caches', name: 'front.clear_cache')]
    public function clearCaches(
        #[Autowire(service: 'cache.global_clearer')] Psr6CacheClearer $clearer
    ): RedirectResponse {
        $clearer->clearPool('cache.app');

        return $this->redirectToRoute('app_admin_dashboard_index');
    }

    #[Route('/', name: 'front.index')]
    public function index(): Response
    {
        return $this->render('homepage.html.twig');
    }

    #[Route('/recache-mascots', name: 'front.recache_mascots')]
    public function recache(
        TagAwareCacheInterface $cache
    ): RedirectResponse {
        $cache->invalidateTags([MascotService::TAG]);

        return $this->redirectToRoute('front.index');
    }

    #[Route('/proxy/{file}', name: 'front.file_proxy')]
    public function proxy(
        Result $file,
        RewriteService $rewriteService
    ): Response {
        $response = $this->client->request('GET', $rewriteService->rewrite($file->getUrl()));

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return new Response('Failed to download file', 500);
        }

        $file->setSeenAt(new \DateTimeImmutable());
        $this->em->persist($file);
        $this->em->flush();

        return $this->download($response->getContent(), 'file-'.$file->getId().'.torrent', $response->getHeaders()['content-type'][0] ?? 'text/plain');
    }

    #[Route('/proxy-api/{file}', name: 'front.file_proxy_api')]
    public function proxyWithApi(
        QBitTorrentService $service,
        Result $file
    ): Response {
        if (!$service->addTorrent($file)) {
            return new Response('Failed to add new torrent via api', 500);
        }

        return $this->redirectToRoute('front.index');
    }

    /**
     * Generate a download.
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
            $response->headers->makeDisposition($disposition, $filename, 'file.'.$ext[count($ext) - 1])
        );

        $response->setContent($contents);

        return $response;
    }
}
