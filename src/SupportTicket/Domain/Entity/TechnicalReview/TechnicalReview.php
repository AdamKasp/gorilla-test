<?php

declare(strict_types=1);

namespace App\SupportTicket\Domain\Entity\TechnicalReview;

use App\SupportTicket\Domain\Entity\Status;
use App\SupportTicket\Domain\Entity\SupportTicketInterface;
use DateTimeImmutable;

final readonly class TechnicalReview implements SupportTicketInterface
{
        private Status $status;
        private ?int $numberOfWeek;
        private DateTimeImmutable $createdAt;
    public function __construct(
        public string $description,
        public ?DateTimeImmutable $dueDate,
        public string $tipsAfterReview,
        public string $contactNumber,
    ) {
        $this->numberOfWeek = $dueDate !== null ? (int) $dueDate->format('W') : null;
        $this->status = $dueDate !== null ? Status::Planned : Status::New;
        $this->createdAt = new DateTimeImmutable();
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function numberOfWeek(): ?int
    {
        return $this->numberOfWeek;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
