<?php

declare(strict_types=1);

namespace App\Rss;

use App\Entity\Rss\Result;
use App\Entity\Rss\Search;
use App\Repository\Rss\ResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Refresher
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ResultRepository $resultRepository,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    ) {
    }

    public function refresh(
        Search $search
    ): false|int {
        $response = $this->client->request(
            'GET',
            sprintf($search->getSource()->getUrl(), urlencode($search->getQuery()))
        );

        if (200 !== $response->getStatusCode()) {
            $this->logger->error('An issue occurred while trying to search', [
                'query' => $search->getQuery(),
                'source' => $search->getSource()->getName(),
                'id' => $search->getId(),
            ]);

            return false;
        }

        $xml = json_decode(json_encode(simplexml_load_string($response->getContent())), true);
        $items = array_reverse($xml['channel']['item'] ?? []);

        if (isset($items['link'])) {
            $items = [$items];
        }

        $count = 0;

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

        return $count;
    }
}
