<?php

namespace App\Report\Formatter;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class CSVFormatter implements FileFormatterInterface
{
    private const ROOT_DIR = '/tmp';

    public function formatAsFile(array $data): File
    {
        $path = $this->getFilePath();

        $this->writeData($data, $path);

        return new File($path);
    }

    private function getFilePath(): string
    {
        return sprintf('%s/%s.csv', self::ROOT_DIR, uniqid());
    }

    private function writeData(array $data, string $path)
    {
        $file = fopen($path, 'w+');

        fputcsv($file, array_keys($data[0]));

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }

    public function formatAsString(array $data): string
    {
    }
}
