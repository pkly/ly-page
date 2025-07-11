<?php

declare(strict_types=1);

namespace App\Media;

use App\Entity\Media\Tag;
use App\Repository\Media\TagRepository;
use App\Repository\Media\WallpaperRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class WallpaperLinker
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly TagRepository $tagRepository,
        private readonly WallpaperRepository $wallpaperRepository,
        #[Autowire(env: 'WALLPAPER_BASE_PATH')] private readonly string $WALLPAPER_BASE_PATH,
        #[Autowire(env: 'WALLPAPER_END_PATH')] private readonly string $WALLPAPER_END_PATH
    ) {
    }

    /**
     * @param iterable<Tag> $tags
     */
    public function update(
        iterable $tags
    ): void {
        $this->cache->delete('wallpaper.tags');
        $this->load($tags);

        // do filesystem linking
        // read old symlinks
        foreach ((new Finder())->in($this->WALLPAPER_END_PATH)->files() as $file) {
            if (is_link($file->getPathname())) {
                unlink($file->getPathname());
            }
        }

        $wallpapers = $this->wallpaperRepository->findWithTags($this->current());

        foreach ($wallpapers as $wallpaper) {
            symlink($this->WALLPAPER_BASE_PATH.'/'.$wallpaper->getPath(), $this->WALLPAPER_END_PATH.'/'.$wallpaper->getPath());
        }
    }

    /**
     * @return list<Tag>
     */
    public function current(): array
    {
        return $this->load();
    }

    /**
     * @param iterable<Tag> $tags
     */
    private function load(
        iterable $tags = []
    ): array {
        $ids = $this->cache->get('wallpaper.tags', function (ItemInterface $item) use ($tags): array {
            $item->expiresAt(new \DateTime('+5 years'));

            $ids = [];

            foreach ($tags as $tag) {
                $ids[] = $tag->getId();
            }

            return $ids;
        });

        return $this->tagRepository->findBy(['id' => $ids]);
    }
}
