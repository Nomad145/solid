<?php

namespace App\Repository;

use App\Report\LimitedNightlySalesReport;
use App\Report\NightlySalesReport;
use App\Report\ReportInterface;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportRepository implements ReportRepositoryInterface
{
    /** @var ReportInterface[] */
    private $inMemoryCollection;

    public function __construct()
    {
        $this->inMemoryCollection = [
            new NightlySalesReport([
                'ceo@bigsales.net',
                'cfo@bigsales.net',
                'marketing@bigsales.net',
            ]),
            new LimitedNightlySalesReport(['manager@bigsales.net'], 1),
        ];
    }

    public function findOneByName(string $name): ?ReportInterface
    {
        $reports = array_filter(
            $this->inMemoryCollection,
            function (ReportInterface $report) use ($name) {
                return $name === $report->getName();
            }
        );

        if (empty($reports)) {
            return null;
        }

        return array_shift($reports);
    }
}
