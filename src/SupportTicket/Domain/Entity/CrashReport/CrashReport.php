<?php

declare(strict_types=1);

namespace App\SupportTicket\Domain\Entity\CrashReport;

use App\SupportTicket\Domain\Entity\Priority;
use App\SupportTicket\Domain\Entity\Status;
use App\SupportTicket\Domain\Entity\SupportTicketInterface;
use DateTimeImmutable;

final readonly class CrashReport implements SupportTicketInterface
{
    private Priority $priority;
    private Status $status;
    private DateTimeImmutable $createdAt;
    public function __construct(
        public string $description,
        public ?dateTimeImmutable $dueDate,
        public string $serviceNotes,
        public string $contactNumber,
    ) {
        $this->priority = $this->processPriority($description);
        $this->status = $dueDate !== null ? Status::Termin : Status::New;
        $this->createdAt = new DateTimeImmutable();
    }

    public function priority(): Priority
    {
        return $this->priority;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
    private function processPriority(string $description): Priority
    {
        $description = strtolower($description);

        if (str_contains($description, 'bardzo pilne')) {
            return Priority::Critical;
        }

        if (str_contains($description, 'pilne')) {
            return Priority::High;
        }

        return Priority::Normal;
    }
}
