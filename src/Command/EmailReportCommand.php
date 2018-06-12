<?php

namespace App\Command;

use App\Report\Formatter\FormatterInterface;
use App\Report\Mailer\ReportMailerInterface;
use App\Repository\ReportRepositoryInterface;
use Doctrine\DBAL\Connection;
use Swift_Attachment as Attachment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        ReportRepositoryInterface $reportRepo,
        FormatterInterface $formatter
    ) {
        parent::__construct();

        $this->dbal = $dbal;
        $this->mailer = $mailer;
        $this->reportRepo = $reportRepo;
        $this->formatter = $formatter;
    }

    protected function configure()
    {
        $this->setDescription('Gather report info and deliver it to recipients as an email attachment');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $report = $this->reportRepo->findOneByName('Nightly Sales Report');

        $data = $this->dbal->query($report->getQuery())->fetchAll();

        $file = $this->formatter->formatAsFile($data);

        $this->mailer->sendReportAsAttachment($report, $file);
    }
}
