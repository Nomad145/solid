<?php

namespace Tests\Report\Mailer;

use App\Report\Mailer\ReportMailer;
use App\Report\ReportInterface;
use PHPUnit\Framework\TestCase;
use Swift_Mailer as SwiftMailer;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportMailerTest extends TestCase
{
    public function testSendReportAsAttachment()
    {
        $report = $this->createMock(ReportInterface::class);
        $file = $this->createMock(File::class);

        $report
            ->method('getName')
            ->willReturn('Test Report');

        $report
            ->method('getRecipients')
            ->willReturn(['foo@gmail.com']);

        $file
            ->method('__toString')
            ->willReturn('/tmp/test.csv');

        $mailer = $this->createMock(SwiftMailer::class);

        $mailer
            ->expects($this->once())
            ->method('send');

        $subject = new ReportMailer($mailer);

        $subject->sendReportAsAttachment($report, $file);
    }
}
