<?php

declare(strict_types=1);

namespace App\SupportTicket\Infastructure\Cli;

use App\SupportTicket\Application\Factory\SupportTicketFactory;
use App\SupportTicket\Domain\Entity\TechnicalReview\TechnicalReview;
use App\SupportTicket\Domain\Repository\SupportTicketRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'support:ticket-report:generate',
    description: 'it generates a report of all support tickets from provided file',
)]
final class SupportTicketReportGeneratorCommand extends Command
{

    public function __construct(
        private readonly SupportTicketFactory $supportTicketFactory,
        private readonly SupportTicketRepositoryInterface $supportTicketRepository
    ) {
        parent::__construct();
    }
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathFromInput = $input->getArgument('file') !== null ? $input->getArgument('file') : __DIR__ . '/../../../../input.json';

        $supportTickets = $this->supportTicketRepository->getAllSupportTickets($pathFromInput);

        $crashReports = [];
        $technicalReviews = [];
        $processedSupportTicketsDescriptions = [];

        foreach ($supportTickets as $supportTicket) {
            if (in_array($supportTicket['description'], $processedSupportTicketsDescriptions)) {
                $processedSupportTicketsDescriptions[] = $supportTicket['description'];
                continue;
            }
            $supportTicket = $this->supportTicketFactory->createSupportTicketFromArray($supportTicket);
            if ($supportTicket instanceof TechnicalReview) {
                $technicalReviews[] = $supportTicket->getArrayPreparedToPrint();
            } else {
                $crashReports[] = $supportTicket->getArrayPreparedToPrint();
            }
        }
        $output->writeln('reports generated');

        $output->writeln('there is ' . count($crashReports) . ' crash reports');
        $output->writeln('there is ' . count($technicalReviews) . ' technical reviews');

        if(count($processedSupportTicketsDescriptions) > 0) {
            $output->writeln('there is ' . count($processedSupportTicketsDescriptions) . ' duplicated support tickets');

        }

        file_put_contents("crashReport.json", json_encode($crashReports, JSON_PRETTY_PRINT));
        file_put_contents("technicalReview.json", json_encode($technicalReviews, JSON_PRETTY_PRINT));

        $output->writeln('reports saved to files');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::OPTIONAL, 'Path to file with support tickets')
        ;
    }
}

