<?php

declare(strict_types=1);

namespace App\SupportTicket\Domain\Entity\TechnicalReview;

use App\SupportTicket\Domain\Entity\SupportTicketInterface;
use DateTimeImmutable;

final readonly class TechnicalReview implements SupportTicketInterface
{
    public function __construct(
        private string $description,
        private string $type,
        private dateTimeImmutable $dueDate,
        private int $numberOfWeek,
        private string $status,
        private string $tipsAfterReview,
        private string $contactNumber,
        private string $createdAt,
    ) {
    }

    public function getKeywords (): array
    {
        return['przegląd', ];
    }
}
