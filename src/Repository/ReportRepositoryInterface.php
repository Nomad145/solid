<?php

namespace App\Repository;

use App\Report\ReportInterface;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface ReportRepositoryInterface
{
    public function findOneByName(string $name): ?ReportInterface;
}
