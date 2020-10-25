<?php
declare(strict_types=1);


namespace Tests;


class Export extends \PHPUnit\Framework\TestCase
{
    public function testFileHandlerClassExists(): void
    {
        self::assertFileExists(dirname(__DIR__) . '/src/Export.php');
    }
}