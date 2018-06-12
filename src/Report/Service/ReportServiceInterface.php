<?php

namespace App\Report\Service;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface ReportServiceInterface
{
    public function generateReport(string $report): void;
}
