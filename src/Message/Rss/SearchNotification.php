<?php

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
