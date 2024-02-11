<?php

namespace App\Command;

use App\Entity\Rss\Result;
use App\Repository\Rss\ResultRepository;
use App\Repository\Rss\SearchRepository;
use App\Traits\EntityManagerTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:cron-search',
    description: 'Run possible cron searches'
)]
class RssSearchCommand extends Command
{
    use EntityManagerTrait;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SearchRepository $searchRepository,
        private readonly ResultRepository $resultRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        $count = 0;

        foreach ($this->searchRepository->findBy(['active' => true]) as $search) {
            $response = $this->client->request(
                'GET',
                sprintf($search->getRssGroup()->getUrl(), urlencode($search->getQuery()))
            );

            if (200 !== $response->getStatusCode()) {
                $io->error(
                    sprintf(
                        'An issue occurred while trying to search for %s in %s (id: %s)',
                        $search->getQuery(),
                        $search->getRssGroup()->getName(),
                        $search->getId()
                    )
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

        if ($count > 0) {
            $io->success(
                sprintf(
                    'Found new %s results',
                    $count
                )
            );
        } else {
            $io->warning('No new results found');
        }

        return Command::SUCCESS;
    }
}
