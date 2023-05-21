<?php

declare(strict_types=1);

namespace App\Tests\SupportTicket\Application\Factory;

use App\SupportTicket\Application\Factory\SupportTicketFactory;
use App\SupportTicket\Domain\Entity\CrashReport\CrashReport;
use App\SupportTicket\Domain\Entity\Priority;
use App\SupportTicket\Domain\Entity\Status;
use App\SupportTicket\Domain\Entity\TechnicalReview\TechnicalReview;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SupportTicketFactoryTest extends TestCase
{
    public function testCreatesTechnicalReviewFromArray(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>" przegląd opis",
            "dueDate"=>"2020-02-03 15:15",
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(TechnicalReview::class, $supportTicket);
        Assert::assertSame($supportTicket->status(), Status::Planned);
    }

    public function testCreatesTechnicalReviewFromArrayWithNullDueDate(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>" przegląd opis",
            "dueDate"=>null,
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(TechnicalReview::class, $supportTicket);
        Assert::assertSame($supportTicket->status(), Status::New);
        Assert::assertNull($supportTicket->dueDate);
    }

    public function testCreatesTechnicalReviewFromArrayWithProperlyCalculatedWeekOfYear(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>" przegląd opis",
            "dueDate"=>"2020-01-03 15:15",
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(TechnicalReview::class, $supportTicket);
        Assert::assertSame($supportTicket->numberOfWeek(), 1);
    }

    public function testCreatesCrashReportFromArray(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>" awaria opis",
            "dueDate"=>"2020-02-03 15:15",
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(CrashReport::class, $supportTicket);
        Assert::assertSame($supportTicket->priority(), Priority::Normal);
        Assert::assertSame($supportTicket->status(), Status::Termin);
    }

    public function testCreatesCrashReportFromArrayWithCriticalPriority(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>" bardzo pilne awaria opis",
            "dueDate"=>"2020-02-03 15:15",
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(CrashReport::class, $supportTicket);
        Assert::assertSame($supportTicket->priority(), Priority::Critical);
    }

    public function testCreatesCrashReportFromArrayWithHighPriority(): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>"pilne awaria opis",
            "dueDate"=>"2020-02-03 15:15",
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(CrashReport::class, $supportTicket);
        Assert::assertSame($supportTicket->priority(), Priority::High);
    }

    /**
     * @dataProvider invalidDateProvider
     */
    public function testCreatesCrashReportFromArrayWithoutDueDate(mixed $date): void
    {
        $factory = new SupportTicketFactory();

        $item = [
            "number" => 4,
            "description" =>"pilne awaria opis",
            "dueDate"=> $date,
            "phone"=>"666-445-127"
        ];

        $supportTicket = $factory->createSupportTicketFromArray($item);
        Assert::assertInstanceOf(CrashReport::class, $supportTicket);
        Assert::assertSame($supportTicket->priority(), Priority::High);
        Assert::assertSame($supportTicket->status(), Status::New);
    }

    public static function invalidDateProvider(): array
    {
        return [
            'null value' => [null],
            'empty string' => [''],
        ];
    }
}
