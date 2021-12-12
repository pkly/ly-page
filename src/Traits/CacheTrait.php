<?php

namespace App\Traits;

use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait CacheTrait
{
    protected TagAwareCacheInterface $cache;

    #[Required]
    public function setCache(
        TagAwareCacheInterface $cache
    ): void {
        $this->cache = $cache;
    }
}