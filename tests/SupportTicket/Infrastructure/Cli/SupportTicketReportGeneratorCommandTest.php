<?php

declare(strict_types=1);

namespace App\Tests\SupportTicket\Infrastructure\Cli;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class SupportTicketReportGeneratorCommandTest extends KernelTestCase
{
    private const PATH = __DIR__ . '/../../../../input.json';

    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('support:ticket-report:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'file' => self::PATH,
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('reports generated', $output);
        $this->assertStringContainsString('there is 13 crash reports', $output);
        $this->assertStringContainsString('there is 5 technical reviews', $output);
        $this->assertStringContainsString('there is 2 duplicated support tickets', $output);
        $this->assertStringContainsString('id of duplicated support ticket: 11', $output);
        $this->assertStringContainsString('id of duplicated support ticket: 16', $output);
        $this->assertStringContainsString('crashReport.json report saved to file', $output);
        $this->assertStringContainsString('technicalReview.json report saved to file', $output);
        $this->assertStringContainsString('duplicates.json report saved to file', $output);

        $this->assertFileExists(__DIR__ . '/../../../../crashReport.json');
        $this->assertFileExists(__DIR__ . '/../../../../technicalReview.json');
        $this->assertFileExists(__DIR__ . '/../../../../duplicates.json');
    }
}
