<?php

declare(strict_types=1);

namespace App\SupportTicket\Application\Generator;

use App\SupportTicket\Application\Factory\SupportTicketFactory;
use App\SupportTicket\Domain\Entity\TechnicalReview\TechnicalReview;

final class SupportTicketReportGenerator
{
    public function __construct(private SupportTicketFactory $supportTicketFactory)
    {}
    public function generateReport(array $supportTickets): array
    {
        $crashReports = [];
        $technicalReviews = [];
        $processedSupportTicketsDescriptions = [];
        $idsOfDuplicates = [];

        foreach ($supportTickets as $supportTicket) {
            if (in_array($supportTicket['description'], $processedSupportTicketsDescriptions)) {
                $processedSupportTicketsDescriptions[] = $supportTicket['description'];
                $idsOfDuplicates[] = $supportTicket['number'];
                continue;
            }
            $supportTicket = $this->supportTicketFactory->createSupportTicketFromArray($supportTicket);
            if ($supportTicket instanceof TechnicalReview) {
                $technicalReviews[] = $supportTicket->getArrayPreparedToPrint();
            } else {
                $crashReports[] = $supportTicket->getArrayPreparedToPrint();
            }
        }

        return [
            'technicalReviews' => $technicalReviews,
            'crashReports' => $crashReports,
            'duplicatedSupportTickets' => $processedSupportTicketsDescriptions,
            'idsOfDuplicates' => $idsOfDuplicates,
        ];
    }
}