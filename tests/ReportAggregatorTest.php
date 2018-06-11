<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\ReportAggregator;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportAggregatorTest extends TestCase
{
    public function testAggregate()
    {
        $subject = new ReportAggregator();

        $subject->aggregate();
    }
}
