<?php

namespace Report\Formatter;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface StringFormatterInterface
{
    public function formatAsString(array $data): string;
}
