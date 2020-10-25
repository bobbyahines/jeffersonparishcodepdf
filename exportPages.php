<?php
declare(strict_types=1);


use BobbyAHines\JeffersonParishCodePdf\FileHandler;

require_once __DIR__ . '/vendor/autoload.php';

$dir = scandir(__DIR__ . '/resources/txt');
unset($dir[0], $dir[1], $dir[2]);

if (count($dir) > 1) {
    echo 'FAILURE! More than one TEXT is present in the pdf directory.';
    echo PHP_EOL;
}

if (count($dir) < 1) {
    echo 'FAILURE! No TEXT is present in the pdf directory. Run the converter!';
    echo PHP_EOL;
}

$fileName = $dir[3];
$filePath = __DIR__ . '/resources/txt/' . $fileName;

$fileHandler = new FileHandler();
$fileContents = $fileHandler->ReadTextFile();
unset($fileHandler);

$exportPages = new \BobbyAHines\JeffersonParishCodePdf\ExportPages($fileContents);
$saveExportedPages = $exportPages->export();
unset($exportPages);

echo PHP_EOL;
echo '===================================================================================' . PHP_EOL;
echo $fileName . ' has been exported to a text file per page.' . PHP_EOL;
echo $saveExportedPages . ' files now found @ ' . __DIR__ . '/exports/pages/*.txt' . PHP_EOL;
echo 'Completed: ' . date(DATE_ATOM) . PHP_EOL;
echo '===================================================================================' . PHP_EOL;
echo PHP_EOL;
