<?php

namespace App\Report;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
final class LimitedNightlySalesReport extends NightlySalesReport
{
    private const NAME = 'Limited Nightly Sales Report';

    public function __construct(array $recipients, int $limit)
    {
        parent::__construct($recipients);

        $this->limit = $limit;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getQuery(): string
    {
        return sprintf('SELECT * FROM report_data LIMIT %d', $this->limit);
    }
}
