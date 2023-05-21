<?php

declare(strict_types=1);

namespace App\Tests\SupportTicket\Application\Generator;

use App\SupportTicket\Application\Factory\SupportTicketFactory;
use App\SupportTicket\Application\Generator\SupportTicketReportGenerator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SupportTicketReportGeneratorTest extends TestCase
{
    public function testGeneratesSupportTicketReports(): void
    {
        $generator = new SupportTicketReportGenerator(new SupportTicketFactory());

        $reports = $generator->generateReport($this->getArray());
        Assert::assertIsArray($reports);

        Assert::assertArrayHasKey('technicalReviews', $reports);
        Assert::assertIsArray($reports['technicalReviews']);
        Assert::assertCount(1, $reports['technicalReviews']);

        Assert::assertArrayHasKey('crashReports', $reports);
        Assert::assertIsArray($reports['crashReports']);
        Assert::assertCount(2, $reports['crashReports']);

        Assert::assertArrayHasKey('idsOfDuplicates', $reports);
        Assert::assertIsArray($reports['idsOfDuplicates']);
        Assert::assertCount(1, $reports['idsOfDuplicates']);
        Assert::assertSame(3, $reports['idsOfDuplicates'][0]);
    }

    private function getArray(): array
    {
        return [
            [
                "number" => 1,
                "description" => "Awaria klimatyzacji. Na salonie temperatura wzrosła do 27 stopni. Pozdrawiam Ela.",
                "dueDate" => "2020-01-04 13:30:00",
                "phone" => ""
            ],
            [
                "number" => 2,
                "description" => "Prośba o przegląd",
                "dueDate" => "2020-01-07 00:30:11",
                "phone" => "\""
            ],
            [
                "number" => 3,
                "description" => "Prośba o przegląd",
                "dueDate" => "2020-02-01 04:32:00",
                "phone" => "4"
            ],
            [
                "number" => 4,
                "description" => " Odpada tynk między szafą, regałem a witryną, proszę o doklejenie go.",
                "dueDate" => "2020-02-03 15:15",
                "phone" => "666-445-127",
            ]
        ];
    }
}
