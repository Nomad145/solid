<?php

namespace App\Report;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface ReportInterface
{
    public function getName(): string;

    public function getRecipients(): array;

    public function getQuery(): string;
}
