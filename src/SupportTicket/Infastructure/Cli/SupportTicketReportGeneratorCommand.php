<?php

declare(strict_types=1);

namespace App\SupportTicket\Infastructure\Cli;

use App\SupportTicket\Application\Generator\SupportTicketReportGenerator;
use App\SupportTicket\Domain\Repository\SupportTicketRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'support:ticket-report:generate',
    description: 'it generates a report of all support tickets from provided file, if no file is provided it will use input.json file',
)]
final class SupportTicketReportGeneratorCommand extends Command
{
    private const DEFAULT_FILE_PATH = __DIR__ . '/../../../../input.json';
    public function __construct(
        private readonly SupportTicketRepositoryInterface $supportTicketRepository,
        private readonly SupportTicketReportGenerator $supportTicketReportGenerator
    ) {
        parent::__construct();
    }
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathFromInput = $input->getArgument('file') !== null ? $input->getArgument('file') : self::DEFAULT_FILE_PATH;

        $supportTickets = $this->supportTicketRepository->getAllSupportTickets($pathFromInput);

        $technicalReviews = $this->supportTicketReportGenerator->generateReport($supportTickets)['technicalReviews'];
        $crashReports = $this->supportTicketReportGenerator->generateReport($supportTickets)['crashReports'];
        $idsOfDuplicates = $this->supportTicketReportGenerator->generateReport($supportTickets)['idsOfDuplicates'];

        $output->writeln('reports generated');

        $output->writeln('there is ' . count($crashReports) . ' crash reports');
        $output->writeln('there is ' . count($technicalReviews) . ' technical reviews');

        $this->printInfoAboutDuplications($idsOfDuplicates, $output);

        $this->generateReportToFile($crashReports, 'crashReport.json', $output);

        $this->generateReportToFile($technicalReviews, 'technicalReview.json', $output);

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::OPTIONAL, 'Path to file with support tickets')
        ;
    }

    private function printInfoAboutDuplications(
        array $idsOfDuplicates,
        OutputInterface $output
    ): void {
        $countOfDuplicates = count($idsOfDuplicates);

        if ($countOfDuplicates > 0) {
            $output->writeln('there is ' . $countOfDuplicates . ' duplicated support tickets');
            foreach ($idsOfDuplicates as $id) {
                $output->writeln('id of duplicated support ticket: ' . $id);
            }
        }
    }

    private function generateReportToFile(array $report, string $fileName, OutputInterface $output): void
    {
        if(file_put_contents($fileName, json_encode($report, JSON_PRETTY_PRINT))) {
            $output->writeln($fileName . ' report saved to file');
        } else {
            $output->writeln($fileName . ' report not saved to file');
        }
    }
}

