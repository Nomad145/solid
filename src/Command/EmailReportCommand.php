<?php

namespace App\Command;

use App\Report\Formatter\CSVFormatter;
use App\Repository\ReportRepositoryInterface;
use Doctrine\DBAL\Connection;
use Swift_Attachment as Attachment;
use Swift_Mailer as Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailReportCommand extends Command
{
    protected static $defaultName = 'app:email-report';

    public function __construct(
        Connection $dbal,
        Mailer $mailer,
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
        $data = $this->dbal->query('SELECT * FROM report_data')->fetchAll();

        $filePath = $this->writeCSVFile($data);

        $this->sendMailAttachment($filePath);
    }

    private function writeCSVFile(array $data): string
    {
        $formatter = new CSVFormatter();

        return (string) $formatter->formatAsFile($data);
    }

    private function sendMailAttachment(string $filePath): void
    {
        $report = $this->reportRepo->findOneByName('Nightly Sales Report');

        $message = (new \Swift_Message($report->getName()))
            ->setFrom('no-reply@bigsales.net')
            ->setTo($report->getRecipients())
            ->attach(Attachment::fromPath($filePath));

        $this->mailer->send($message);
    }
}
