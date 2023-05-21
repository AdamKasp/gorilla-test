<?php

declare(strict_types=1);

namespace App\Tests\SupportTicket\Infrastructure;

use App\SupportTicket\Infastructure\Repository\SupportTicketFromFileRepository;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SupportTicketFromFileRepositoryTest extends TestCase
{
    private const PATH = 'input.json';

    public function testGetAllSupportTickets(): void
    {
        $supportTicketRepository = new SupportTicketFromFileRepository();

        $supportTickets = $supportTicketRepository->getAllSupportTickets(self::PATH);

        Assert::assertIsArray($supportTickets);
        // todo: finish this test
    }
}
