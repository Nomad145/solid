<?php

namespace Tests\Repository;

use PHPUnit\Framework\TestCase;
use App\Repository\ReportRepository;
use App\Report\NightlySalesReport;
use App\Report\LimitedNightlySalesReport;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportRepositoryTest extends TestCase
{
    public function testFindOneByName()
    {
        $subject = new ReportRepository();

        $report = $subject->findOneByName('Nightly Sales Report');

        self::assertInstanceOf(NightlySalesReport::class, $report);

        $report = $subject->findOneByName('Limited Nightly Sales Report');

        self::assertInstanceOf(LimitedNightlySalesReport::class, $report);
    }

    public function testFindOneByNameReturnsNull()
    {
        $subject = new ReportRepository();

        $report = $subject->findOneByName('Monthly New Customer Report');

        self::assertNull($report);
    }
}
