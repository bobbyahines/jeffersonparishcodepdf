<?php
declare(strict_types=1);


namespace BobbyAHines\JeffersonParishCodePdf;


final class ExportPages extends Export
{

    /**
     * @return array
     */
    private function pageSplitter(): array
    {
        return explode("\x0C", $this->fullText);
    }

    /**
     * @param int $number
     * @return string
     */
    private function pageFileName(int $number): string
    {
        if ($number < 10) {
            return '0' . $number . '-page.txt';
        }

        return $number . '-page.txt';
    }

    /**
     * @param string $page
     * @param string $fileName
     * @return ?int
     */
    private function savePageAsTextFile(string $page, string $fileName): ?int
    {
        $pagesDirectory = dirname(__DIR__, 1) . '/exports/pages/';
        $pageFileName = $pagesDirectory . $fileName;

        return file_put_contents($pageFileName, $page);
    }

    /**
     * @return int
     */
    public function export(): int
    {
        $arrayOfPageStrings = $this->pageSplitter();

        for ($i = 0, $iMax = count($arrayOfPageStrings); $i < $iMax; ++$i) {
            $pageFileName = $this->pageFileName($i + 1);
            $this->savePageAsTextFile($arrayOfPageStrings[$i], $pageFileName);
        }

        return count($arrayOfPageStrings);
    }
}