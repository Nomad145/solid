<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedDatabaseCommand extends Command
{
    protected static $defaultName = 'app:seed-database';

    /** @var Generator */
    private $faker;

    public function __construct(Generator $faker, Connection $dbal)
    {
        parent::__construct();

        $this->faker = $faker;
        $this->dbal = $dbal;
    }

    protected function configure()
    {
        $this
            ->setDescription('Seed the database with faker data')
            ->addOption('records', null, InputOption::VALUE_REQUIRED, 'Number of records to create', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $numberOfRecords = (int) $input->getOption('records');

        $records = array_map([$this, 'makeRecord'], range(0, $numberOfRecords));

        $this->saveRecords($records);
    }

    private function makeRecord(): array
    {
        return [
            'order_id' => $this->faker->randomNumber(8),
            'customer_id' => $this->faker->randomNumber(6),
            'total_amount' => $this->faker->randomFloat(2),
            'total_items' => $this->faker->numberBetween(2, 10),
        ];
    }

    private function saveRecords(array $records): void
    {
        foreach ($records as $record) {
            $this->dbal->insert('report_data', $record);
        }
    }
}
