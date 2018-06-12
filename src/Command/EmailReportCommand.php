<?php

namespace App\Command;

use App\Report\Formatter\CSVFormatter;
use App\Report\Mailer\ReportMailerInterface;
use App\Report\ReportInterface;
use App\Repository\ReportRepositoryInterface;
use Doctrine\DBAL\Connection;
use Swift_Attachment as Attachment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;

class EmailReportCommand extends Command
{
    protected static $defaultName = 'app:email-report';

    /** @var Connection */
    private $dbal;

    /** @var ReportMailerInterface */
    private $mailer;

    /** @var ReportRepositoryInterface */
    private $reportRepo;

    public function __construct(
        Connection $dbal,
        ReportMailerInterface $mailer,
        ReportRepositoryInterface $reportRepo
    ) {
        parent::__construct();

        $this->dbal = $dbal;
        $this->mailer = $mailer;
        $this->reportRepo = $reportRepo;
    }

    protected function configure()
    {
        $this->setDescription('Gather report info and deliver it to recipients as an email attachment');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $report = $this->reportRepo->findOneByName('Nightly Sales Report');

        $data = $this->dbal->query($report->getQuery())->fetchAll();

        $file = $this->writeCSVFile($data);

        $this->mailer->sendReportAsAttachment($report, $file);
    }

    private function writeCSVFile(array $data): File
    {
        $formatter = new CSVFormatter();

        return $formatter->formatAsFile($data);
    }
}
