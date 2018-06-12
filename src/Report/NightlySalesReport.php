<?php

namespace App\Report;

use InvalidArgumentException;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class NightlySalesReport implements ReportInterface
{
    private const NAME = 'Nightly Sales Report';

    private $recipients = [];

    public function __construct(array $recipients)
    {
        if (!$this->recipientsAreValid($recipients)) {
            throw new InvalidArgumentException('Invalid email address given');
        }

        $this->recipients = $recipients;
    }

    private function recipientsAreValid(array $recipients): bool
    {
        foreach ($recipients as $recipient) {
            if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
