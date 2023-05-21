<?php

declare(strict_types=1);

namespace App\SupportTicket\Domain\Entity\CrashReport;

use App\SupportTicket\Domain\Entity\SupportTicketInterface;
use DateTimeImmutable;

final readonly class CrashReport implements SupportTicketInterface
{
    public function __construct(
        private string $description,
        private string $type,
        private string $priority,
        private ?dateTimeImmutable $dueDate,
        private string $status,
        private string $serviceNotes,
        private string $contactNumber,
        private string $createdAt,
    ) {
    }

    public function getKeywords (): array
    {
        return[];
    }
}
