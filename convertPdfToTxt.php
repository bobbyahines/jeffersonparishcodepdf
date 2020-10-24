<?php
declare(strict_types=1);


use BobbyAHines\JeffersonParishCodePdf\FileHandler;

require_once __DIR__ . '/vendor/autoload.php';

$dir = scandir(__DIR__ . '/resources/pdf');
unset($dir[0], $dir[1]);

if (count($dir) > 1) {
    echo 'FAILURE! More than one PDF is present in the pdf directory.';
    echo PHP_EOL;
}

if (count($dir) < 1) {
    echo 'FAILURE! No PDF is present in the pdf directory.';
    echo PHP_EOL;
}

$fileName = $dir[2];
$filePath = __DIR__ . '/resources/pdf/' . $fileName;

$fileHandler = new FileHandler($filePath);
$fileContents = $fileHandler->savePdfAsText();
unset($fileHandler);

echo PHP_EOL;
echo '==============================================================================' . PHP_EOL;
echo $fileName . ' has been converted to a text file.' . PHP_EOL;
echo 'Found @ ' . __DIR__ . '/resources/txt/plainTxtConversion.txt' . PHP_EOL;
echo 'Completed: ' . date(DATE_ATOM) . PHP_EOL;
echo '==============================================================================' . PHP_EOL;
echo PHP_EOL;
