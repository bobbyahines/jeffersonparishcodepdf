<?php
declare(strict_types=1);


namespace BobbyAHines\JeffersonParishCodePdf;


use ErrorException;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;

class FileHandler
{
    protected string $pdfFilePath;
    protected string $txtFilePath;

    /**
     * FileHandler constructor.
     * @param string $pdfFilePath
     */
    public function __construct(string $pdfFilePath)
    {
        $this->pdfFilePath = $pdfFilePath;
        $this->txtFilePath = dirname(__DIR__, 1) . '/resources/txt/plainTxtConversion.txt';
    }

    /**
     * Save the PDF resource as a Text file.
     * @return bool
     */
    public function savePdfAsText(): bool
    {
        $pdfToText = new Pdf();

        try {
            $pdfToText->setPdf($this->pdfFilePath);
        } catch (PdfNotFound $exception) {
            echo $exception->getMessage();
        }

        $fileContents = $pdfToText->text();
        unset($pdfToText);

        $saved = file_put_contents($this->txtFilePath, $fileContents);
        unset($fileContents);

        if (!$saved) {
            return false;
        }

        return true;
    }

    /**
     * Delete the PDF resource file.
     * @return bool
     */
    public function deletePdfFile(): bool
    {
        try {
            unlink($this->pdfFilePath);
            if (file_exists($this->pdfFilePath)) {
                throw new ErrorException('Failed to delete file.');
            }
            return true;
        } catch (ErrorException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Delete the Text resource file.
     * @return bool
     */
    public function deleteTextFile(): bool
    {
        try {
            unlink($this->txtFilePath);
            if (file_exists($this->txtFilePath)) {
                throw new ErrorException('Failed to delete file.');
            }
            return true;
        } catch (ErrorException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}