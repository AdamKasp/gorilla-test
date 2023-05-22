<?php

declare(strict_types=1);

namespace App\SupportTicket\Infastructure\Repository;

use App\SupportTicket\Domain\Repository\SupportTicketRepositoryInterface;

final class SupportTicketFromFileRepository implements SupportTicketRepositoryInterface
{
    public function getAllSupportTickets(string $path): array
    {
        $json = file_get_contents($path, true);
        $data = json_decode($json, true);
        return $data;
    }
}
