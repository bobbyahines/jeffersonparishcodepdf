<?php
declare(strict_types=1);


use BobbyAHines\JeffersonParishCodePdf\FileHandler;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * PDF FILE RESOURCE LOAD
 */

$pdfDir = scandir(__DIR__ . '/resources/pdf');
unset($pdfDir[0], $pdfDir[1], $pdfDir[2]);

if (count($pdfDir) > 1) {
    echo 'FAILURE! More than one PDF is present in the pdf directory.';
    echo PHP_EOL;
}

if (count($pdfDir) < 1) {
    echo 'FAILURE! No PDF is present in the pdf directory.';
    echo PHP_EOL;
}

$pdfFileName = $pdfDir[3];
$pdfFilePath = __DIR__ . '/resources/pdf/' . $pdfFileName;

$fileHandler = new FileHandler();
$pdfFileContents = $fileHandler->savePdfAsText($pdfFilePath);
unset($fileHandler);

/**
 * TEXT FILE RESOURCE LOAD
 */

$txtDir = scandir(__DIR__ . '/resources/txt');
unset($txtDir[0], $txtDir[1], $txtDir[2]);

if (count($txtDir) > 1) {
    echo 'FAILURE! More than one TEXT is present in the pdf directory.';
    echo PHP_EOL;
}

if (count($txtDir) < 1) {
    echo 'FAILURE! No TEXT is present in the pdf directory. Run the converter!';
    echo PHP_EOL;
}

$txtFileName = $txtDir[3];
$txtFilePath = __DIR__ . '/resources/txt/' . $txtFileName;

$fileHandler = new FileHandler();
$txtFileContents = $fileHandler->ReadTextFile();
unset($fileHandler);

/**
 * BUILD CHARTER DOCUMENT
 */

$charter = new \BobbyAHines\JeffersonParishCodePdf\Structured\Charter($txtFileContents);
unset($txtFileContents);

/**
 * WRITE MARKDOWN FILES
 */
$markdownDir = __DIR__ . '/exports/markdown';
$savePreambleAsIndexFile = file_put_contents($markdownDir . '/index.md', $charter->preamble);

$count = 0;
foreach ($charter->chapters as $chapter) {
    ++$count;
    $fileNumber = $count >= 10 ? '0' . $count : $count;
    $saveChapter = file_put_contents($markdownDir . '/chapter_' . $fileNumber . '.md', $chapter);
}

echo PHP_EOL;
echo '===================================================================================' . PHP_EOL;
echo ' PDF file\'s Charter section has been exported to basic markdown pages.' . PHP_EOL;
echo ' These can now found @ ' . __DIR__ . '/exports/markdown/*.md' . PHP_EOL;
echo ' Completed: ' . date(DATE_ATOM) . PHP_EOL;
echo '===================================================================================' . PHP_EOL;
echo PHP_EOL;