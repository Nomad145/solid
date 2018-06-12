<?php

namespace Tests\Report\Service;

use App\Report\Formatter\FormatterInterface;
use App\Report\Mailer\ReportMailerInterface;
use App\Report\NightlySalesReport;
use App\Report\Service\ReportService;
use App\Repository\ReportRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use UnexpectedValueException;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportServiceTest extends TestCase
{
    public function setUp()
    {
        $this->dbal = $this->createMock(Connection::class);
        $this->mailer = $this->createMock(ReportMailerInterface::class);
        $this->repo = $this->createMock(ReportRepositoryInterface::class);
        $this->formatter = $this->createMock(FormatterInterface::class);

        $this->subject = new ReportService($this->dbal, $this->mailer, $this->repo, $this->formatter);
    }

    public function testGenerateReport()
    {
        $statement = $this->createMock(Statement::class);
        $file = $this->createMock(File::class);
        $report = new NightlySalesReport(['foo@gmail.com']);

        $this
            ->repo
            ->expects($this->once())
            ->method('findOneByName')
            ->with('Nightly Sales Report')
            ->willReturn($report);

        $statement
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn([['foo' => 'bar']]);

        $this
            ->dbal
            ->expects($this->once())
            ->method('query')
            ->with($report->getQuery())
            ->willReturn($statement);

        $this
            ->formatter
            ->expects($this->once())
            ->method('formatAsFile')
            ->with([['foo' => 'bar']])
            ->willReturn($file);

        $this
            ->mailer
            ->expects($this->once())
            ->method('sendReportAsAttachment')
            ->with($report, $file);

        $this->subject->generateReport('Nightly Sales Report');
    }

    public function testGenerateReportThrowsException()
    {
        $this
            ->repo
            ->method('findOneByName')
            ->willReturn(null);

        $this->expectException(UnexpectedValueException::class);

        $this->subject->generateReport('Nightly Sales Report');
    }
}
