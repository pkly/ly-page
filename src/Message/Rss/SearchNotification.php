<?php

declare(strict_types=1);

namespace App\Message\Rss;

use App\Entity\Rss\Search;

class SearchNotification
{
    public function __construct(
        private readonly Search $search
    ) {
    }

    public function getSearch(): Search
    {
        return $this->search;
    }
}
