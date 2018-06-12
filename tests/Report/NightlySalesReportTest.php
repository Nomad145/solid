<?php

namespace App\Tests\Report;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use App\Report\NightlySalesReport;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class NightlySalesNightlySalesReportTest extends TestCase
{
    public function testNightlySalesReport()
    {
        $recipients = ['foo@gmail.com', 'bar@yahoo.com'];

        $subject = new NightlySalesReport($recipients);

        self::assertEquals($recipients, $subject->getRecipients());
        self::assertEquals('Nightly Sales Report', $subject->getName());
    }

    public function testThrowsInvalidArgumentException()
    {
        $recipients = ['foo@invaliddomain'];

        $this->expectException(InvalidArgumentException::class);

        $subject = new NightlySalesReport($recipients);
    }

    public function testGetQuery()
    {
        $recipients = ['foo@gmail.com', 'bar@yahoo.com'];

        $subject = new NightlySalesReport($recipients);

        self::assertEquals('SELECT * FROM report_data', $subject->getQuery());
    }
}
