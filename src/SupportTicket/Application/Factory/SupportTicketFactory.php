<?php

declare(strict_types=1);

namespace App\SupportTicket\Application\Factory;

use App\SupportTicket\Domain\Entity\CrashReport\CrashReport;
use App\SupportTicket\Domain\Entity\TechnicalReview\TechnicalReview;
use DateTimeImmutable;

final class SupportTicketFactory
{
    public function createSupportTicketFromArray(array $item): CrashReport|TechnicalReview
    {
        if (str_contains($item['description'], 'przegląd')) {
            return $this->createTechnicalReview(
                $item['description'],
                !empty($item['dueDate']) ? new DateTimeImmutable($item['dueDate']) : null,
                $item['phone'],
            );
        }

        return $this->createCrashReport(
            $item['description'],
            !empty($item['dueDate']) ? new DateTimeImmutable($item['dueDate']) : null,
            $item['phone'],
        );
    }
    public function createCrashReport(
        ?string $description,
        ?dateTimeImmutable $dueDate,
        ?string $contactNumber,
        ?string $serviceNotes = '',
    ): CrashReport {
        return new CrashReport(
            $description,
            $dueDate,
            $serviceNotes,
            $contactNumber,
        );
    }

    public function createTechnicalReview(
        ?string $description,
        ?dateTimeImmutable $dueDate,
        ?string $contactNumber,
        ?string $tipsAfterReview = '',
    ): TechnicalReview {
        return new TechnicalReview(
            $description,
            $dueDate,
            $tipsAfterReview,
            $contactNumber,
        );
    }
}
