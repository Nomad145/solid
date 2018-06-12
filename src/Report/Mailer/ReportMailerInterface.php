<?php

namespace App\Report\Mailer;

use App\Report\ReportInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface ReportMailerInterface
{
    public function sendReportAsAttachment(ReportInterface $report, File $file);
}
