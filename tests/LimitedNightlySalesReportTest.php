<?php

namespace Test;

use App\Report\LimitedNightlySalesReport;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class LimitedNightlySalesReportTest extends TestCase
{
    public function testGetName()
    {
        $subject = new LimitedNightlySalesReport(['foo@gmail.com'], 1);

        self::assertEquals('Limited Nightly Sales Report', $subject->getName());
    }

    public function testGetQuery()
    {
        $subject = new LimitedNightlySalesReport(['foo@gmail.com'], 1);

        self::assertEquals('SELECT * FROM report_data LIMIT 1', $subject->getQuery());
    }
}
