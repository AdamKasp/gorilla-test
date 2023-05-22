<?php

declare(strict_types=1);

namespace App\Tests\SupportTicket\Infrastructure\Repository;

use App\SupportTicket\Infastructure\Repository\SupportTicketFromFileRepository;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SupportTicketFromFileRepositoryTest extends TestCase
{
    private const PATH = __DIR__ . '/../../testInput.json';

    public function testGetAllSupportTickets(): void
    {
        $supportTicketRepository = new SupportTicketFromFileRepository();

        $supportTickets = $supportTicketRepository->getAllSupportTickets(self::PATH);

        Assert::assertIsArray($supportTickets);
        Assert::assertCount(2, $supportTickets);

        Assert::assertSame(1, $supportTickets[0]['number']);
        Assert::assertSame("Awaria klimatyzacji. Na salonie temperatura wzrosła do 27 stopni. Pozdrawiam Ela.", $supportTickets[0]['description']);
        Assert::assertSame("2020-01-04 13:30:00", $supportTickets[0]['dueDate']);
        Assert::assertSame("", $supportTickets[0]['phone']);

        Assert::assertSame(2, $supportTickets[1]['number']);
        Assert::assertSame("Prośba o wizytę    ", $supportTickets[1]['description']);
        Assert::assertSame("2020-01-07 00:30:11", $supportTickets[1]['dueDate']);
        Assert::assertSame("\"", $supportTickets[1]['phone']);
    }
}
