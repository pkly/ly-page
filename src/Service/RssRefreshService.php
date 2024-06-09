<?php

namespace App\Service;

use App\Entity\Rss\Result;
use App\Repository\Rss\ResultRepository;
use App\Repository\Rss\SearchRepository;
use App\Traits\EntityManagerTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RssRefreshService
{
    use EntityManagerTrait;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SearchRepository $searchRepository,
        private readonly ResultRepository $resultRepository,
    ) {
    }

    /**
     * @return array{0: list<string>, 1: int}
     */
    public function refresh(): array
    {
        $errors = [];
        $count = 0;

        foreach ($this->searchRepository->findBy(['active' => true]) as $search) {
            $response = $this->client->request(
                'GET',
                sprintf($search->getRssGroup()->getUrl(), urlencode($search->getQuery()))
            );

            if (200 !== $response->getStatusCode()) {
                $errors[] = sprintf(
                    'An issue occurred while trying to search for %s in %s (id: %s)',
                    $search->getQuery(),
                    $search->getRssGroup()->getName(),
                    $search->getId()
                );

                continue;
            }

            $xml = json_decode(json_encode(simplexml_load_string($response->getContent())), true);
            $items = array_reverse($xml['channel']['item'] ?? []);

            if (isset($items['link'])) {
                $items = [$items];
            }

            foreach ($items as $item) {
                if (null !== $this->resultRepository->findOneBy(['guid' => $item['guid']])) {
                    continue;
                }

                $found = (new Result())
                    ->setTitle($item['title'] ?? 'Unknown title?')
                    ->setGuid($item['guid'])
                    ->setUrl($item['link'])
                    ->setData($item)
                    ->setSearch($search);

                $this->em->persist($found);
                $this->em->flush();
                $count++;
            }
        }

        return [
            $errors,
            $count,
        ];
    }
}
