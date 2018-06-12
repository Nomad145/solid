<?php

namespace App\Command;

use App\Report\Service\ReportServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailReportCommand extends Command
{
    protected static $defaultName = 'app:email-report';

    /** @var ReportServiceInterface */
    private $reportService;

    public function __construct(ReportServiceInterface $reportService)
    {
        parent::__construct();

        $this->reportService = $reportService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Gather report info and deliver it to recipients as an email attachment')
            ->addArgument('report', InputArgument::REQUIRED, 'Which report would you like to send?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->reportService->generateReport($input->getArgument('report'));
    }
}
