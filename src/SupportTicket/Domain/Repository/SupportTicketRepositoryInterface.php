<?php

declare(strict_types=1);

namespace App\SupportTicket\Domain\Repository;

interface SupportTicketRepositoryInterface
{
    public function getAllSupportTickets(string $path): array;
}
