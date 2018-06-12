<?php

namespace App\Report\Mailer;

use App\Report\ReportInterface;
use Swift_Attachment as SwiftAttachment;
use Swift_Mailer as SwiftMailer;
use Swift_Message as SwiftMessage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class ReportMailer implements ReportMailerInterface
{
    private const FROM = 'no-reply@bigsales.net';

    public function __construct(SwiftMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendReportAsAttachment(ReportInterface $report, File $file)
    {
        $message = new SwiftMessage($report->getName());

        $message->setFrom(self::FROM);
        $message->setTo($report->getRecipients());
        $message->attach(SwiftAttachment::fromPath((string) $file));

        $this->mailer->send($message);
    }
}
