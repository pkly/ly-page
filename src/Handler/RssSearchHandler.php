<?php

declare(strict_types=1);

namespace App\Handler;

use App\Message\Rss\GenericSearchNotification;
use App\Repository\Rss\SearchRepository;
use App\Rss\Refresher;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RssSearchHandler
{
    public function __construct(
        private readonly Refresher $refresher,
        private readonly SearchRepository $repository
    ) {
    }

    #[AsMessageHandler]
    public function handle(
        GenericSearchNotification $notification
    ): void {
        if (null === ($entity = $this->repository->findNextToRefresh())) {
            return;
        }

        $this->refresher->refresh($entity);
    }
}
