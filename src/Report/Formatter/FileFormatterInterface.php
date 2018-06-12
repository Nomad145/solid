<?php

namespace App\Report\Formatter;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
interface FileFormatterInterface
{
    public function formatAsFile(array $data): File;
}
