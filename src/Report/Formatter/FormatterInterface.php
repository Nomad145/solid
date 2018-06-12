<?php

namespace App\Report\Formatter;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface FormatterInterface
{
    public function formatAsFile(array $data): File;

    public function formatAsString(array $data): string;
}
