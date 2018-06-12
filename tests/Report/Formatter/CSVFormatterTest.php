<?php

namespace Tests\Report\Formatter;

use App\Report\Formatter\CSVFormatter;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * @author Michael Phillips <michael.phillips@realpage.com>
 */
class CSVFormatterTest extends TestCase
{
    public function testFormatAsFile()
    {
        $data = [
            [
                'foo' => 'bar',
                'hello' => 'world',
                'key' => 'value',
            ],
        ];

        $subject = new CSVFormatter();

        $file = $subject->formatAsFile($data);

        self::assertRegExp('/\/tmp\/.*\.csv/', (string) $file);
        self::assertEquals('foo,hello,key'.PHP_EOL.'bar,world,value'.PHP_EOL, file_get_contents($file));
    }
}
