<?php

namespace App\Command;

use App\Service\RssRefreshService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cron-search',
    description: 'Run possible cron searches'
)]
class RssSearchCommand extends Command
{
    public function __construct(
        private readonly RssRefreshService $refreshService,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        [$errors, $count] = $this->refreshService->refresh();

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

        foreach ($errors as $error) {
            $io->error($error);
        }

        return Command::SUCCESS;
    }
}
