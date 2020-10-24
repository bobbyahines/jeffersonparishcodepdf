<?php
declare(strict_types=1);


namespace Tests;


use Spatie\PdfToText\Pdf;

class FileHandler extends \PHPUnit\Framework\TestCase
{
    public function testFileHandlerClassExists(): void
    {
        self::assertFileExists(dirname(__DIR__) . '/src/FileHandler.php');
    }
}