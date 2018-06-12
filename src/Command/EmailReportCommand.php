<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Swift_Attachment as Attachment;
use Swift_Mailer as Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailReportCommand extends Command
{
    protected static $defaultName = 'app:email-report';

    public function __construct(Connection $dbal, Mailer $mailer)
    {
        parent::__construct();

        $this->dbal = $dbal;
        $this->mailer = $mailer;
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
        $filePath = '/tmp/'.uniqid().'.csv';

        $fp = fopen($filePath, 'w+');

        fputcsv($fp, array_keys($data[0]));

        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);

        return $filePath;
    }

    private function sendMailAttachment(string $filePath): void
    {
        $message = (new \Swift_Message('Nightly Sales Report'))
            ->setFrom('no-reply@bigsales.net')
            ->setTo('ceo@bigsales.net')
            ->attach(Attachment::fromPath($filePath));

        $this->mailer->send($message);
    }
}
