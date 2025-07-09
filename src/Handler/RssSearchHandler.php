<?php

namespace App\Handler;

use App\Message\Rss\SearchNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RssSearchHandler
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    #[AsMessageHandler]
    public function handle(
        SearchNotification $notification
    ): void {

    }
}
