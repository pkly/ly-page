<?php

namespace App\Torrent;

use App\Entity\Rss\Result;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * A helper for WebUI, only for legal sources, obviously.
 */
class QBitTorrentService
{
    private string|null $session = null;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly HttpClientInterface $client,
        private readonly RouterInterface $router,
        #[Autowire(env: 'QBITTORRENT_URL')] private readonly string $QBITTORRENT_URL,
        #[Autowire(env: 'QBITTORRENT_USERNAME')] private readonly string $QBITTORRENT_USERNAME,
        #[Autowire(env: 'QBITTORRENT_PASSWORD')] private readonly string $QBITTORRENT_PASSWORD,
        #[Autowire(env: 'QBITTORRENT_BASE_PATH')] private readonly string $QBITTORRENT_BASE_PATH
    ) {
    }

    public function add(
        Result $file
    ): bool {
        if (null === $this->session && !$this->login()) {
            return false;
        }

        try {
            $data = [
                'urls' => $this->router->generate('front.file_proxy', ['file' => $file->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            ];

            if (null !== $file->getSearch()?->getDirectory()) {
                $data['savepath'] = rtrim($this->QBITTORRENT_BASE_PATH, '/\\').DIRECTORY_SEPARATOR.ltrim($file->getSearch()->getDirectory(), '/\\');
            }

            $response = $this->client->request('POST', $this->QBITTORRENT_URL.'/api/v2/torrents/add', [
                'body' => $data,
                'headers' => [
                    'Cookie: SID='.$this->session,
                ],
            ]);

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error('Unable to add torrents', ['content' => $response->getContent(false)]);

                return false;
            }
        } catch (\Throwable $e) {
            $this->logger->error('Exception occurred', ['message' => $e->getMessage()]);

            return false;
        }

        return true;
    }

    private function login(): bool
    {
        try {
            $response = $this->client->request('POST', $this->QBITTORRENT_URL.'/api/v2/auth/login', [
                'body' => [
                    'username' => $this->QBITTORRENT_USERNAME,
                    'password' => $this->QBITTORRENT_PASSWORD,
                ],
            ]);

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error('Unable to login', ['content' => $response->getContent(false)]);

                return false;
            }

            if (null === ($header = $response->getHeaders(false)['set-cookie'][0] ?? null)) {
                $this->logger->error('Unable to login, no cookie', ['content' => $response->getContent(false)]);

                return false;
            }
            $this->session = explode('=', explode(';', $header)[0])[1];
        } catch (\Throwable $e) {
            $this->logger->error('Exception occurred', ['message' => $e->getMessage()]);

            return false;
        }

        return true;
    }
}
