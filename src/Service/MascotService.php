<?php

namespace App\Service;

use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class MascotService
{
    public const TAG = 'mascot.service';

    public function __construct(
        private readonly TagAwareCacheInterface $cache,
        private readonly string $MASCOT_PATH
    ) {
    }

    public function getMascot(
        array $paths = []
    ): SplFileInfo|null {
        return null;
    }

    public function getDirectories(): array
    {
        return $this->cache->get(self::TAG.'.mascots.directories', function (ItemInterface $item) {
            $item->tag(self::TAG)
                ->expiresAfter(1);

            try {
                return array_values(
                    array_map(
                        fn (SplFileInfo $f) => $f->getRelativePathname(),
                        iterator_to_array((new Finder())->in($this->MASCOT_PATH)->directories())
                    )
                );
            } catch (DirectoryNotFoundException) {
                return [];
            }
        });
    }

    private function loadMascots(): array
    {
        return $this->cache->get(self::TAG.'.mascots', function (ItemInterface $item) {
            $item->tag(self::TAG)
                ->expiresAfter(15);

            try {
                return array_values(
                    array_map(
                        fn (SplFileInfo $f) => $f->getRelativePathname(),
                        iterator_to_array((new Finder())->in(rtrim($this->MASCOT_PATH, '/\\').DIRECTORY_SEPARATOR.'*')->files())
                    )
                );
            } catch (DirectoryNotFoundException) {
                return [];
            }
        });
    }
}