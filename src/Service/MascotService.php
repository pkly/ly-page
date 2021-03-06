<?php

namespace App\Service;

use App\Traits\CacheTrait;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Contracts\Cache\ItemInterface;

class MascotService
{
    use CacheTrait;

    private int|null $mascotCounter = null;

    public const TAG = 'mascot.service';

    public function __construct(
        private readonly string $MASCOT_PATH,
        private readonly string $PUBLIC_DIR
    ) {
    }

    public function getMascot(
        int $counter = 0,
        array $paths = []
    ): SplFileInfo|null {
        $this->mascotCounter = count($mascots = $this->getMascots($paths));
        if (null === ($mascot = $mascots[$counter] ?? null)) {
            return null;
        }

        $rel = mb_substr($this->MASCOT_PATH, mb_strlen($this->PUBLIC_DIR));
        return new SplFileInfo($this->MASCOT_PATH.DIRECTORY_SEPARATOR.$mascot, $rel.DIRECTORY_SEPARATOR.$mascot, $rel);
    }

    public function getLastMascotCount(): int
    {
        return $this->mascotCounter;
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

    private function getMascots(
        array $paths = []
    ): array {
        $key = self::TAG.'.mascots';
        foreach ($paths as $path) {
            $key .= '.'.strtr($path, ItemInterface::RESERVED_CHARACTERS, str_repeat('_', mb_strlen(ItemInterface::RESERVED_CHARACTERS)));
        }

        return $this->cache->get($key, function (ItemInterface $item) use ($paths) {
            $item->tag(self::TAG)
                ->expiresAfter(60 * 60 * 24 * 60); // 2 months

            $trimmed = rtrim($this->MASCOT_PATH, '/\\');
            $dirs = [];

            foreach ($paths as $path) {
                $dirs[] = $trimmed.DIRECTORY_SEPARATOR.$path.'*';
            }

            if (empty($dirs)) {
                $dirs[] = $trimmed.'*';
            }

            try {
                $results = array_values(
                    array_map(
                        fn (SplFileInfo $f) => mb_substr($f->getRealPath(), mb_strlen($this->MASCOT_PATH) + 1),
                        iterator_to_array((new Finder())->in($dirs)->files())
                    )
                );
                shuffle($results);

                return $results;
            } catch (DirectoryNotFoundException) {
                return [];
            }
        });
    }
}