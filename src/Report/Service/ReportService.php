<?php

namespace App\Report\Service;

use App\Report\Formatter\FormatterInterface;
use App\Report\Mailer\ReportMailerInterface;
use App\Repository\ReportRepositoryInterface;
use Doctrine\DBAL\Connection;
use UnexpectedValueException;
use App\Report\Service\ReportServiceInterface;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportService implements ReportServiceInterface
{
    public function __construct(
        Connection $dbal,
        ReportMailerInterface $mailer,
        ReportRepositoryInterface $reportRepo,
        FormatterInterface $formatter
    ) {
        $this->dbal = $dbal;
        $this->mailer = $mailer;
        $this->reportRepo = $reportRepo;
        $this->formatter = $formatter;
    }

    public function generateReport(string $reportName): void
    {
        $report = $this->reportRepo->findOneByName($reportName);

        if (null === $report) {
            throw new UnexpectedValueException(sprintf(
                'Unable to find report %s',
                $reportName
            ));
        }

        $data = $this->dbal->query($report->getQuery())->fetchAll();

        $file = $this->formatter->formatAsFile($data);

        $this->mailer->sendReportAsAttachment($report, $file);
    }
}
