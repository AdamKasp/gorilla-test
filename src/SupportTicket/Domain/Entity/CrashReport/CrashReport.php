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
        public ?string $description = '',
        public ?dateTimeImmutable $dueDate = null,
        public ?string $serviceNotes = '',
        public ?string $contactNumber = '',
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

    public function getArrayPreparedToPrint(): array
    {
        return [
            'opis' => $this->description,
            'typ' => 'zgłoszenie awarii',
            'priorytet' => $this->priority->value,
            'termin_wizyty' => $this->dueDate !== null ? $this->dueDate->format('Y-m-d') : '',
            'status' => $this->status->value,
            'uwagi_serwisu' => $this->serviceNotes,
            'telefon_kontaktowy' => $this->contactNumber,
            'data_utworzenia' => $this->createdAt->format('Y-m-d'),
        ];
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
