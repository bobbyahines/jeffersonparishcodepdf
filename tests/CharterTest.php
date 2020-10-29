<?php
declare(strict_types=1);


namespace Tests;


class CharterTest extends \PHPUnit\Framework\TestCase
{
    public function testCharterClassExists(): void
    {
        self::assertFileExists(dirname(__DIR__) . '/src/Charter.php');
    }
}