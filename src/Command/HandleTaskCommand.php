<?php

namespace App\Command;

use App\Exception\InvalidFileExtensionException;
use App\Service\HandleFile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:handle-task',
    description: 'Handle request from file',
)]
class HandleTaskCommand extends Command
{
    public function __construct(private readonly HandleFile $handleFile)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::REQUIRED, 'Path to file')
        ;
    }

    /**
     * @throws InvalidFileExtensionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument('path');

        if ($path) {
            $io->note(sprintf('You passed a path to a file: %s', $path));

            list($review, $accident, $failed, $failedNumber) = $this->handleFile->handle($path);

            $io->info('Total processed message: '.$review + $accident + $failed);
            $io->success('Succeeded accident notification processed message: '.$accident);
            $io->success('Succeeded review processed message: '.$review);
            $io->error(sprintf('Failed processed message: %d for numbers %s', $failed, json_encode($failedNumber)));
        }

        return Command::SUCCESS;
    }
}
