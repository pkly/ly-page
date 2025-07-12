<?php

declare(strict_types=1);

namespace App\Mascot;

use App\Entity\Media\MascotGroup;
use App\Repository\Media\MascotRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MascotProvider
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly MascotRepository $repository
    ) {
    }

    /**
     * @return array{0: string, 1: string}|null
     */
    public function get(
        MascotGroup $group
    ): array|null {
        /** @var list<array{0: string, 1: string}> $mascots */
        $mascots = $this->cache->get('mascot.'.$group->getId(), function (ItemInterface $item) use ($group): array {
            $item->expiresAt(new \DateTime('+1 month'));

            $outputs = [];

            foreach ($this->repository->findWithTags($group->getTags()) as $mascot) {
                $outputs[] = [
                    $mascot->getPath(),
                    $mascot->getExt(),
                ];
            }

            return $outputs;
        });

        if (empty($mascots)) {
            return null;
        }

        $key = $this->cache->get('mascot.'.$group->getId().'.current', function (ItemInterface $item) use ($mascots): int {
            $item->expiresAt(new \DateTime('+60 seconds'));

            return array_rand($mascots);
        });

        return $mascots[$key];
    }

    public function update(
        MascotGroup $group
    ): void {
        $this->cache->delete('mascot.'.$group->getId());
        $this->cache->delete('mascot.'.$group->getId().'.current');
    }
}
